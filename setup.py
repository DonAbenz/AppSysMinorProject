from cx_Freeze import setup, Executable
import os.path
import sys

os.environ['TCL_LIBRARY'] = 'C:\\Users\\XBoss\\Miniconda3\\tcl\\tcl8.6'
os.environ['TK_LIBRARY'] = 'C:\\Users\\XBoss\\Miniconda3\\tcl\\tk8.6'

# import PyQt5.QtQuick
# from PyQt5.QtWidgets import *
# from PyQt5.QtQml import *
# from PyQt5.QtCore import *
# from PyQt5.QtGui import *
# ['atexit', 'os', 'sys', 'numpy','numpy.core._methods', 'fuzzywuzzy','PyQt5.QtQuick','PyQt5.QtWidgets','PyQt5.QtQml','PyQt5.QtCore','PyQt5.QtGui']

path_platforms = ("C:\\Users\\XBoss\\Miniconda3\\pkgs\\qt-5.6.2-vc14_2\\Library\\plugins\\platforms\\qwindows.dll", "platforms\qwindows.dll")
includes = ['atexit', 'os', 'sys', 'numpy','numpy.core._methods', 'fuzzywuzzy','PyQt5.QtQuick','PyQt5','PyQt5.uic']
includefiles = [path_platforms]
excludes = ['_gtkagg','_tkagg','bsddb','curses','pywin.debugger','pywin.debugger.dbgcon','pywin.dialogs','tcl','Tkconstants','Tkinter']
packages = ['os','numpy.lib.format']
path = []

build_exe_options = {
    'includes': includes,
    'include_files': includefiles,
    'excludes': excludes,
    'packages': packages,
    'path': path
}

base = None
exe = None

if sys.platform == 'win32':
    exe = Executable(
        script= 'C:\\Users\\XBoss\\Documents\\GitHub\\erp_cleaner\\test.py',
        initScript = None,
        base = 'Win32GUI',
        targetName = 'ERPcleaner.exe',
        icon = None
    )

setup(
    name = 'telll',
    version = '0.1',
    description = 'clean stuff',
    author = 'Xboss',
    author_email = 'abenojadonell@gmail.com',
    options = {'build_exe': build_exe_options},
    executables = [exe]
)

