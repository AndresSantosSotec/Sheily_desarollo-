pipeline {
    agent any

    environment {
        DB_HOST = 'localhost'
        DB_USER = 'root'
        DB_PASSWORD = ''
        DB_NAME = 'corposystemas_bd'
    }

    stages {
        stage('Clonar repositorio') {
            steps {
                echo 'Clonando repositorio desde GitHub...'
                git branch: 'main', url: 'https://github.com/AndresSantosSotec/Sheily_desarollo-.git'
            }
        }

        stage('Instalar Apache y dependencias PHP') {
            steps {
                echo 'Instalando Apache y dependencias PHP...'
                sh '''
                # Instalar Apache si no está instalado
                sudo apt-get update
                sudo apt-get install -y apache2

                # Instalar PHP y módulos necesarios
                sudo apt-get install -y php libapache2-mod-php php-mysql

                # Asegurarse de que Composer esté instalado
                sudo apt-get install -y composer

                # Reiniciar Apache para asegurarse de que todo esté configurado correctamente
                sudo service apache2 restart
                '''
            }
        }

        stage('Instalar dependencias del proyecto') {
            steps {
                echo 'Instalando dependencias del proyecto PHP...'
                sh 'composer install'
            }
        }

        stage('Configurar Apache y permisos de proyecto') {
            steps {
                echo 'Configurando Apache para servir el proyecto...'
                sh '''
                # Configurar Apache para servir el proyecto desde /var/www/html
                sudo rm -rf /var/www/html/*
                sudo cp -r * /var/www/html/

                # Dar permisos correctos a los archivos y reiniciar Apache
                sudo chown -R www-data:www-data /var/www/html/
                sudo chmod -R 755 /var/www/html/
                sudo service apache2 restart
                '''
            }
        }

        stage('Configurar Base de Datos') {
            steps {
                echo 'Cargando la base de datos corposystemas_bd...'
                sh '''
                # Crear la base de datos si no existe
                mysql -h ${DB_HOST} -u ${DB_USER} -p${DB_PASSWORD} -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME};"

                # Cargar el archivo de la base de datos corposystemas_bd.sql
                mysql -h ${DB_HOST} -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} < corposystemas_bd.sql
                '''
            }
        }

        stage('Pruebas con Selenium') {
            steps {
                echo 'Ejecutando pruebas automatizadas con Selenium...'
                sh '''
                python3 -m venv venv
                source venv/bin/activate
                pip install -r requirements.txt
                python3 -m unittest discover Caja_negra
                '''
            }
        }

        stage('Generar Informes') {
            steps {
                echo 'Generando informes de pruebas...'
                sh '''
                mkdir -p reports
                pytest --junitxml=reports/report.xml
                '''
            }
            post {
                always {
                    junit 'reports/report.xml'
                }
            }
        }

        stage('Despliegue') {
            steps {
                echo 'Desplegando aplicación...'
            }
        }
    }

    post {
        always {
            echo 'Pipeline completado.'
        }
        success {
            echo 'El pipeline se ejecutó exitosamente.'
        }
        failure {
            echo 'El pipeline falló.'
            // Comentando el envío de correo hasta que el SMTP esté configurado
            // mail to: 'desarrolladores@empresa.com',
            //      subject: 'Error en el Pipeline Jenkins',
            //      body: "El pipeline ha fallado. Verifica los errores en ${env.BUILD_URL}."
        }
    }
}
