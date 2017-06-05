for %%* in (.) do set CurrDirName=%%~nx*
echo %CurrDirName%

@echo off & setlocal EnableDelayedExpansion 

set a=%CurrDirName%
for /f "delims=" %%i in ('dir /b *.*.php') do (
  ren "%%i" "!a!.*.php" 
) 

for /f "delims=" %%i in ('dir /b *.*.js') do (
  ren "%%i" "!a!.*.js" 
) 

for /f "delims=" %%i in ('dir /b *.*.css') do (
  ren "%%i" "!a!.*.css" 
) 
