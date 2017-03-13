#!/usr/bin/env groovy

node('master') {
   try {
       stage('build') {
           git url: 'git@bitbucket.org:bikebitants/bikebitants.git'

            //Build containers again to build changes
            sh './develop build'

            // Start services (Let docker-compose build containers for testing)
           sh "./develop up -d"

           // Get composer dependencies
           sh "./develop composer install"

           // Create .env file for testing
           sh '/var/lib/jenkins/.venv/bin/aws s3 cp s3://bikebitants-secrets/env-ci .env'
           sh './develop art key:generate'
       }

       stage('test') {
           sh "./develop npm install"
           sh "./develop bower install"
           sh "./develop npm production"
           sh "APP_ENV=testing ./develop test"
       }

       if( env.BRANCH_NAME == 'master' ) {
           stage('package') {
               sh './docker/build'
           }

            stage('deploy') {
               sh 'ssh -i ~/.ssh/id_sd enricu@10.1.1.13 /opt/deploy'
            }
       }
   } catch(error) {
       // Maybe some alerting?
       throw error
   } finally {
       // Spin down containers no matter what happens
       sh './develop down'
   }
}