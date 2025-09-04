@echo off
title Atualizar Projeto
color 0a

echo =====================================
echo   Sistema de Atualizacao do Projeto
echo =====================================
echo.
echo Script iniciado


REM Caminho do projeto - ajuste conforme necessario
set PROJECT_PATH=C:\Users\AlefDeSouzaSobrinho\Desktop\coisas\xampp\htdocs\mvc-biblioteca
echo Variavel PROJECT_PATH definida


REM Verifica se o Git está instalado
where git >nul 2>&1
echo Teste do comando WHERE GIT feito, errolevel=%errorlevel%


if %errorlevel% neq 0 (
    echo Git nao encontrado. Baixando e instalando...

    set "GIT_URL=https://github.com/git-for-windows/git/releases/download/v2.47.1.windows.1/Git-2.47.1-64-bit.exe"
    echo Variavel GIT_URL definida


    set "GIT_INSTALLER=%temp%\git-installer.exe"
    echo Variavel GIT_INSTALLER definida


    powershell -Command "Invoke-WebRequest -Uri %GIT_URL% -OutFile %GIT_INSTALLER%"
    echo Download do instalador concluido

)
REM Vai até a pasta do projeto
cd /d "%PROJECT_PATH%"
echo Entrou na pasta do projeto


echo Verificando atualizacoes no GitHub...
git pull
echo Git pull executado, errolevel=%errorlevel%


IF %ERRORLEVEL% EQU 0 (
    echo.
    echo Projeto atualizado com sucesso!
    echo.
    echo Arquivos alterados recentemente:
    git log -1 --name-only --pretty=format:""
    echo Git log executado

) ELSE (
    echo.
    echo Ocorreu um erro ao atualizar o projeto.
    echo Verifique sua conexao com a internet.
    echo.
    echo Falha no git pull
)

echo ---------------------------
pause