@echo off
setlocal ENABLEDELAYEDEXPANSION
title Sincronizador de Banco - XAMPP
echo ============================================
echo   Sincronizador Banco x Dump (.sql) - SAFE
echo ============================================
echo.

REM Ajuste estes caminhos/parametros conforme seu ambiente:
set PHP="C:\Users\AlefDeSouzaSobrinho\Desktop\coisas\xampp\php\php.exe"
set SCRIPT="C:\Users\AlefDeSouzaSobrinho\Desktop\coisas\xampp\htdocs\mvc-biblioteca\testedb.php"
set DUMP="C:\Users\AlefDeSouzaSobrinho\Desktop\coisas\xampp\htdocs\mvc-biblioteca\mvc_biblioteca.sql"
set DB=mvc_biblioteca
set HOST=127.0.0.1
set USER=root
set PASS=
set PORT=3306

if not exist %PHP% (
  echo [ERRO] PHP do XAMPP nao encontrado em %PHP%.
  echo        Ajuste a variavel PHP no .bat.
  goto :end_err
)
if not exist %SCRIPT% (
  echo [ERRO] Script nao encontrado: %SCRIPT%
  goto :end_err
)
if not exist %DUMP% (
  echo [ERRO] Dump SQL nao encontrado: %DUMP%
  goto :end_err
)

echo [INFO] Rodando sincronizacao...
%PHP% %SCRIPT% --sql=%DUMP% --db=%DB% --host=%HOST% --user=%USER% --pass=%PASS% --port=%PORT%
set RET=%ERRORLEVEL%
echo.
if %RET% NEQ 0 (
  echo [ERRO] Sincronizacao falhou. Codigo de saida: %RET%
  echo        Veja as mensagens acima para o ponto exato da falha.
) else (
  echo [OK] Sincronizacao concluida com sucesso.
)
echo.
pause
exit /b %RET%

:end_err
echo.
pause
exit /b 1
