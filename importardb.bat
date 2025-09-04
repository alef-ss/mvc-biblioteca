@echo off
setlocal

REM Caminho do PHP do XAMPP
set PHP_PATH=C:\Users\AlefDeSouzaSobrinho\Desktop\coisas\xampp\php\php.exe

REM Caminho do script PHP
set SCRIPT_PATH=C:\Users\AlefDeSouzaSobrinho\Desktop\coisas\xampp\htdocs\mvc-biblioteca\testedb.php

echo ======================================
echo   Atualizacao do banco de dados
echo ======================================

REM Executa o script PHP no terminal
"%PHP_PATH%" "%SCRIPT_PATH%"

echo ======================================
echo           Processo finalizado
echo ======================================
pause
