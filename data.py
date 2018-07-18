import pandas as pd 
import numpy as np

xlsx_applicants = pd.ExcelFile('C:/Users/XBoss/Documents/GitHub/DBWOJUL1.xlsx')
# /////////////////////////////////////////////////////////////////////////////////////////////////
raw_clark = pd.read_excel(xlsx_applicants,sheet_name='CLARK', converters={'Application Date': str})
raw_clark.columns = raw_clark.columns.str.replace(',', '')
raw_clark.columns = raw_clark.columns.str.replace('\s+', ' ', regex=True)
raw_clark.columns = raw_clark.columns.str.strip().str.lower().str.replace(' ', '_').str.replace('(', '').str.replace(')', '')
raw_clark.rename(columns = {'if_erp_referrer_name': 'referrer_name',
'if_erp_referrer_hrid': 'referrer_hrid'}, inplace=True)
raw_clark = raw_clark.filter(items = ['application_date', 'last_name', 'first_name', 'general_source', 'referrer_name', 'referrer_hrid'])
# ////////////////////////////////////////////////////////////////////////////////////////////////
raw_davao = pd.read_excel(xlsx_applicants,sheet_name='DAVAO', converters={'Application Date': str})
raw_davao.columns = raw_davao.columns.str.replace(',', '')
raw_davao.columns = raw_davao.columns.str.replace('\s+', ' ', regex=True)
raw_davao.columns = raw_davao.columns.str.strip().str.lower().str.replace(' ', '_').str.replace('(', '').str.replace(')', '')
raw_davao.rename(columns = {'if_erp_referrer_name': 'referrer_name',
'if_erp_referrer_hrid': 'referrer_hrid'}, inplace=True)
raw_davao = raw_davao.filter(items = ['application_date', 'last_name', 'first_name', 'general_source', 'referrer_name', 'referrer_hrid'])
# # ////////////////////////////////////////////////////////////////////////////////////////////////
# raw_makati = pd.read_excel(xlsx_applicants,sheet_name='MAKATI', converters={'Application Date': str})
# raw_makati.columns = raw_makati.columns.str.replace(',', '')
# raw_makati.columns = raw_makati.columns.str.replace('\s+', ' ', regex=True)
# raw_makati.columns = raw_makati.columns.str.strip().str.lower().str.replace(' ', '_').str.replace('(', '').str.replace(')', '')
# raw_makati.rename(columns = {'if_erp_referrer_name': 'referrer_name',
# 'if_erp_referrer_hrid': 'referrer_hrid'}, inplace=True)
# raw_makati = raw_makati.filter(items = ['application_date', 'last_name', 'first_name', 'general_source', 'referrer_name', 'referrer_hrid'])
# # /////////////////////////////////////////////////////////////////////////////////////////////////
# raw_moa = pd.read_excel(xlsx_applicants,sheet_name='MOA', converters={'Application Date': str})
# raw_moa.columns = raw_moa.columns.str.replace(',', '')
# raw_moa.columns = raw_moa.columns.str.replace('\s+', ' ', regex=True)
# raw_moa.columns = raw_moa.columns.str.strip().str.lower().str.replace(' ', '_').str.replace('(', '').str.replace(')', '')
# raw_moa.rename(columns = {'if_erp_referrer_name': 'referrer_name',
# 'if_erp_referrer_hrid': 'referrer_hrid'}, inplace=True)
# raw_moa = raw_moa.filter(items = ['application_date', 'last_name', 'first_name', 'general_source', 'referrer_name', 'referrer_hrid'])
# # /////////////////////////////////////////////////////////////////////////////////////////////////
# raw_qc = pd.read_excel(xlsx_applicants,sheet_name='QC', converters={'Application Date': str})
# raw_qc.columns = raw_qc.columns.str.replace(',', '')
# raw_qc.columns = raw_qc.columns.str.replace('\s+', ' ', regex=True)
# raw_qc.columns = raw_qc.columns.str.strip().str.lower().str.replace(' ', '_').str.replace('(', '').str.replace(')', '')
# raw_qc.rename(columns = {'if_erp_referrer_name': 'referrer_name',
# 'if_erp_referrer_hrid': 'referrer_hrid'}, inplace=True)
# raw_qc = raw_qc.filter(items = ['application_date', 'last_name', 'first_name', 'general_source', 'referrer_name', 'referrer_hrid'])



out_xlsx = "char.xlsx"
raw_clark.to_excel(out_xlsx, index=False)

