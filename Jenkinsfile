#!/usr/bin/env groovy

node('master') {
   try {
       stage('build') {
           slackSend color: 'good', message: 'Starting build #$currentBuild.number on "$BRANCH_NAME"'
           git url: 'git@bitbucket.org:bikebitants/bikebitants.git'

           //Build containers again to build changes
           sh './develop build'

           // Start services (Let docker-compose build containers for testing)
           sh "./develop up -d"

           // Get composer dependencies
           sh "./develop composer install"

           // Create .env file for testing
           sh '/var/lib/jenkins/.venv/bin/aws s3 cp s3://bikebitants-keys/env-ci .env'
           sh './develop art key:generate'
       }

       stage('test') {
           slackSend color: 'good', message: 'Starting test phase'
           sh "./develop npm set progress=false"
           sh "./develop npm install "
           sh "./develop bower install"
           sh "./develop npm run production"
           sh "APP_ENV=testing ./develop test"
       }

       if( env.BRANCH_NAME == 'master' ) {
           stage('package') {
               slackSend color: 'good', message: 'Starting package phase'
               sh './docker/build'
           }

            stage('deploy') {
               slackSend color: 'warning', message: 'Starting deploy'
               sh 'ssh -i ~/.ssh/id_sd enricu@10.1.1.13 /opt/deploy'
            }
       }
   } catch(error) {
       // Maybe some alerting?
       slackSend color: 'danger', message: error
       throw error
   } finally {
       // Spin down containers no matter what happens
       slackSend color: 'good', message: 'Ending build'
       sh './develop down'
   }
}