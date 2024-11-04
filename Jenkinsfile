pipeline {
    agent any

    environment {
        DB_HOST = 'localhost'
        DB_USER = 'root'
        DB_PASSWORD = ''  // Agrega la contraseña si es necesaria
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
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    echo 'Instalando Apache, MySQL y dependencias PHP...'
                    sh '''
                    sudo apt-get update
                    sudo apt-get install -y apache2
                    sudo apt-get install -y php libapache2-mod-php php-mysql php-gd
                    sudo apt-get install -y mysql-server
                    sudo service mysql start
                    if ! [ -x "$(command -v composer)" ]; then
                      sudo apt-get install -y composer
                    fi
                    sudo service apache2 restart
                    '''
                }
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
                sudo rm -rf /var/www/html/*
                sudo cp -r * /var/www/html/
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
                mysql -h ${DB_HOST} -u ${DB_USER} -p${DB_PASSWORD} -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME};"
                mysql -h ${DB_HOST} -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} < corposystemas_bd.sql
                '''
            }
        }

        stage('Pruebas con Selenium') {
            steps {
                echo 'Ejecutando pruebas automatizadas con Selenium...'
                sh '''
                Xvfb :99 &
                export DISPLAY=:99
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
                // Aquí puedes agregar comandos de despliegue si es necesario
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
            // mail to: 'desarrolladores@empresa.com',
            //      subject: 'Error en el Pipeline Jenkins',
            //      body: "El pipeline ha fallado. Verifica los errores en ${env.BUILD_URL}."
        }
    }
}
