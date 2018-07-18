import pandas as pd 
import numpy as np
import os
import re
from fuzzywuzzy import fuzz
from fuzzywuzzy import process
from PyQt5 import QtWidgets, uic
from PyQt5.QtWidgets import QFileDialog, QWidget, QMessageBox
from PyQt5.QtGui import QIcon
from PyQt5.QtCore import *

class ERP(QWidget):
    def __init__(self): 
        super().__init__()

    def initUI(self):
        self.setWindowIcon('xvi-favicon-150x150')

    def openFileDialog_1(self):
        options = QFileDialog.Options()
        options |= QFileDialog.DontUseNativeDialog
        path, _ = QFileDialog.getOpenFileName(None, 'Import Excel File', os.getenv('HOME'), 'Excel Files (*.xlsx)')

        if path:
            dlg.lineEdit.setText(path)

    def openFileDialog_2(self):
        options = QFileDialog.Options()
        options |= QFileDialog.DontUseNativeDialog
        path, _ = QFileDialog.getOpenFileName(None, 'Import Excel File', os.getenv('HOME'), 'Excel Files (*.xlsx)')
        
        if path:
            dlg.lineEdit_2.setText(path)
    

    def saveAction(self, path):
        dlg.pushButton_3.setEnabled(False)
        dlg.label_5.setText('Processing Please Wait ...')
        self.cleaner(dlg.lineEdit.text(),dlg.lineEdit_2.text(),path)
        dlg.label_5.setText('')
        QMessageBox.information(self, "", "Done!")
        dlg.pushButton_3.setEnabled(True)
        

    def saveFileDialog(self):
        options = QFileDialog.Options()
        options |= QFileDialog.DontUseNativeDialog
        path, _ = QFileDialog.getSaveFileName(None, 'Import Excel File', os.getenv('HOME'), 'Excel Files (*.xlsx)')
        
        if path:
            self.saveAction(path)
        

    def match_ap_em_id(self, Ref_HRID, raw_emp):
        for row_e in raw_emp.index:     
            emp_id = raw_emp.loc[row_e, 'employee_id']
            emp_name = raw_emp.loc[row_e, 'full_name']
            emp_site = raw_emp.loc[row_e, 'site']                
            if Ref_HRID == emp_id: 
                return emp_id, emp_name, emp_site

    def match_ap_em_name(self, Ref_Name, raw_emp):
        for row_e in raw_emp.index:
            emp_id = raw_emp.loc[row_e, 'employee_id']
            emp_name = raw_emp.loc[row_e, 'full_name']  
            emp_site = raw_emp.loc[row_e, 'site']
            if fuzz.token_sort_ratio(Ref_Name, emp_name) > 95:
                return emp_id, emp_name, emp_site

    def cleaner(self, app, emp, save):

        # Read excel file (applicants)
        xlsx_applicants = pd.ExcelFile(app)
        raw_applicants = pd.read_excel(xlsx_applicants, converters={'Application Date': str})

        # Read excel file (employes)
        xlsx_employees = pd.ExcelFile(emp)
        raw_employees = pd.read_excel(xlsx_employees)

        raw_applicants.columns = raw_applicants.columns.str.replace(',', '')
        raw_applicants.columns = raw_applicants.columns.str.replace('\s+', ' ', regex=True)
        raw_applicants.columns = raw_applicants.columns.str.strip().str.lower().str.replace(' ', '_').str.replace('(', '').str.replace(')', '')
        raw_employees.columns = raw_employees.columns.str.strip().str.lower().str.replace(' ', '_').str.replace('(', '').str.replace(')', '')
        # Rename raw_applicants & raw_employees columns to extract
        raw_applicants.rename(columns = {'if_erp_referrer_name': 'referrer_name',
        'if_erp_referrer_hrid': 'referrer_hrid'}, inplace=True)

        # raw_employees.rename(columns = {'EMPLOYEE ID': 'EMPLOYEE_ID', 'FULL NAME': 'FULL_NAME'}, inplace=True)

        # Filter raw_applicants & raw_employees Columns
        raw_applicants = raw_applicants.filter(items = ['site', 'application_date', 'last_name', 'first_name', 'general_source', 'referrer_name', 'referrer_hrid'])
        raw_employees = raw_employees.filter(items = ['employee_id', 'full_name', 'site'])

        # Filtering raw_applicants rows by column value (ERP)
        booleans = []
        for x in raw_applicants.general_source:
            if x.upper() == 'ERP':
                booleans.append(True)
            else:
                booleans.append(False)

        erp = pd.Series(booleans)

        # Write DataFrame to excel file
        raw_applicants = raw_applicants[erp]
        # Filter rows by non empty field in the columns selected
        raw_applicants = raw_applicants.replace(' ', np.nan)
        raw_employees = raw_employees.replace(' ', np.nan)
        # remove all null fields (Referrer_Name, Referrer_HRID) both in raw_applicants
        raw_applicants = raw_applicants.dropna(subset=['referrer_name','referrer_hrid'], how='all')

        em_id = []
        em_name = []
        em_site = []

        for i in raw_applicants.index:
            QCoreApplication.processEvents()
            ref_hrid = raw_applicants.loc[i, 'referrer_hrid']
            ref_name = raw_applicants.loc[i, 'referrer_name']
            if pd.notna(ref_hrid):
                # if not null, compare referrer_hrid to employee_id
                if self.match_ap_em_id(ref_hrid, raw_employees) != None:
                    e_id, e_name, e_site = self.match_ap_em_id(ref_hrid, raw_employees)
                    em_id.append(e_id)
                    em_name.append(e_name)
                    em_site.append(e_site)
                # if the referrer_id does not match to any of the employee id, proceed to referrer_name
                else:
                    if self.match_ap_em_name(ref_name, raw_employees) != None:
                        e_id, e_name, e_site = self.match_ap_em_name(ref_name, raw_employees)
                        em_id.append(e_id)
                        em_name.append(e_name)
                        em_site.append(e_site)
                    # if theres no match, put null value
                    else:
                        em_id.append(None)
                        em_name.append(None)
                        em_site.append(None)

            # if the referrer_hrid is null proceed to referrer_name
            else:
                if self.match_ap_em_name(ref_name, raw_employees) != None:
                    e_id, e_name, e_site = self.match_ap_em_name(ref_name, raw_employees)
                    em_id.append(e_id)
                    em_name.append(e_name)
                    em_site.append(e_site)
                # if theres no match, put null value
                else:
                    em_id.append(None)
                    em_name.append(None)
                    em_site.append(None)

        ei = np.array(em_id)
        en = np.array(em_name)
        es = np.array(em_site)

        raw_applicants['Employee_ID'] = ei
        raw_applicants['Employee_Name'] = en
        raw_applicants['Employee_Site'] = es

        raw_applicants = raw_applicants.dropna(subset=['Employee_ID','Employee_Name'], how='all')

        out_xlsx = save
        raw_applicants.to_excel(out_xlsx, index=False)

if __name__ == "__main__":

    app  = QtWidgets.QApplication([])
    erp = ERP()
    dlg = uic.loadUi("cleanerUI_v2.ui")

    dlg.pushButton.clicked.connect(erp.openFileDialog_1)
    dlg.pushButton_2.clicked.connect(erp.openFileDialog_2)
    dlg.pushButton_3.clicked.connect(erp.saveFileDialog)

    dlg.show()
    app.exec()



