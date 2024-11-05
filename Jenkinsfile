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

                # Instalar Firefox
                sudo apt-get install -y firefox

                # Instalar Geckodriver (controlador para Firefox)
                GECKODRIVER_VERSION=$(curl -s https://api.github.com/repos/mozilla/geckodriver/releases/latest | grep "tag_name" | cut -d '"' -f 4)
                wget https://github.com/mozilla/geckodriver/releases/download/$GECKODRIVER_VERSION/geckodriver-$GECKODRIVER_VERSION-linux64.tar.gz
                tar -xvzf geckodriver-$GECKODRIVER_VERSION-linux64.tar.gz
                sudo mv geckodriver /usr/local/bin/
                sudo chmod +x /usr/local/bin/geckodriver

                # Crear entorno virtual
                python3 -m venv venv

                # Activar el entorno virtual usando '.'
                . venv/bin/activate

                # Instalar selenium en el entorno virtual
                pip install selenium
                '''
            }
        }

        stage('Ejecutar pruebas Selenium') {
            steps {
                // Ejecutar las pruebas de Selenium que están en el archivo 'pruebas_selenium.py' usando Firefox
                sh '''
                . venv/bin/activate
                python3 prueba_jenkins.py
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