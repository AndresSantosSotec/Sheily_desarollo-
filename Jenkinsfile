pipeline {
    agent any

    environment {
        REPO_URL = 'https://github.com/AndresSantosSotec/Sheily_desarollo-.git'
    }

    stages {
        stage('Clonar repositorio') {
            steps {
                // Clonar el repositorio desde GitHub
                git url: "${REPO_URL}", branch: 'rama_juan'
            }
        }

        stage('Preparar entorno') {
            steps {
                // Actualizar el sistema y preparar el entorno virtual
                sh '''
                sudo apt-get update
                sudo apt-get install -y python3-pip python3-venv

                # Crear entorno virtual
                python3 -m venv venv

                # Activar el entorno virtual usando '.'
                . venv/bin/activate

                # Instalar selenium en el entorno virtual
                pip install selenium

                # Instalar Google Chrome y ChromeDriver
                wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
                sudo apt install -y ./google-chrome-stable_current_amd64.deb

                CHROME_VERSION=$(google-chrome --version | grep -oP '\\d+\\.\\d+\\.\\d+' | head -1)
                wget https://chromedriver.storage.googleapis.com/$CHROME_VERSION/chromedriver_linux64.zip
                unzip chromedriver_linux64.zip
                sudo mv chromedriver /usr/local/bin/
                sudo chmod +x /usr/local/bin/chromedriver
                '''
            }
        }

        stage('Ejecutar pruebas Selenium') {
            steps {
                // Ejecutar las pruebas de Selenium que están en el archivo 'pruebas_selenium.py' usando el entorno virtual
                sh '''
                . venv/bin/activate
                python3 ./prueba_jenkins.py
                '''
            }
        }
    }

    post {
        always {
            // Publicar los artefactos si hay algún resultado de pruebas
            archiveArtifacts artifacts: '/reports/*.html', allowEmptyArchive: true

            // Limpiar el workspace después de cada ejecución
            cleanWs()
        }
        failure {
            // Enviar notificaciones en caso de que falle el pipeline
            echo 'Las pruebas fallaron.'
        }
    }
}