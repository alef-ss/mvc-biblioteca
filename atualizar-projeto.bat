@echo off
title Atualizacao Automatica do Projeto
color 0a

echo ============================================
echo      Sistema de Atualizacao - Clique e Atualize
echo ============================================
echo.

:: Caminho do projeto local
set "PROJECT_PATH=C:\xampp\htdocs\mvc-biblioteca"

:: URL do repositório ZIP no GitHub
set "REPO_ZIP_URL=https://github.com/alef-ss/mvc-biblioteca/archive/refs/heads/main.zip"

:: Caminhos temporários
set "TEMP_ZIP=%temp%\projeto.zip"
set "TEMP_EXTRACT=%temp%\projeto_temp"

echo Baixando atualizacao do GitHub...
powershell -Command "Invoke-WebRequest -Uri '%REPO_ZIP_URL%' -OutFile '%TEMP_ZIP%'"
if %ERRORLEVEL% neq 0 (
    echo Erro ao baixar o arquivo. Verifique a conexao com a internet.
    pause
    exit /b
)

echo Extraindo arquivos...
powershell -Command "Expand-Archive -Path '%TEMP_ZIP%' -DestinationPath '%TEMP_EXTRACT%' -Force"
if %ERRORLEVEL% neq 0 (
    echo Erro ao extrair o arquivo.
    pause
    exit /b
)

echo Sincronizando arquivos com o projeto...

:: Captura automaticamente o nome da pasta extraída dentro de TEMP_EXTRACT
for /d %%i in ("%TEMP_EXTRACT%\*") do set "EXTRACT_FOLDER=%%i"

:: Executa a sincronização com robocopy
robocopy "%EXTRACT_FOLDER%" "%PROJECT_PATH%" /MIR /XD .git /NFL /NDL /NP /NJH /NJS /nc /ns
:: /MIR = espelha pasta (substitui arquivos modificados, adiciona novos e remove os deletados)
:: /XD .git = ignora a pasta .git
:: outros parâmetros = suprimem logs excessivos, deixando o output mais limpo

echo ---------------------------
echo Atualizacao concluida com sucesso!
echo Todos os arquivos do projeto estao sincronizados.
echo ---------------------------

echo Limpando arquivos temporarios...
rmdir /S /Q "%TEMP_EXTRACT%"
del /Q "%TEMP_ZIP%"

pause
