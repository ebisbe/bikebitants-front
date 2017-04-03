#!/usr/bin/env groovy

node('master') {
   try {
       color = 'good'
       stage('build') {
           slackSend color: color, message: "*${currentBuild.displayName}* on *'${BRANCH_NAME}'*"
           if(eJob.changeSets.size() > 0 && eJob.changeSets.items.size() > 0) {
               echo eJob.changeSets[0].items[0].author.fullName
               echo eJob.changeSets[0].items[0].msg
             }
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
           slackSend color: color, message: 'Starting test phase'
           sh "./develop npm set progress=false"
           sh "./develop npm install "
           sh "./develop bower install"
           sh "./develop npm run production"
           sh "APP_ENV=testing ./develop test"
       }

       if( env.BRANCH_NAME == 'master' ) {
           stage('package') {
               slackSend color: color, message: 'Starting package phase'
               sh './docker/build'
           }

            stage('deploy') {
                color = 'warning'
                slackSend color: color, message: 'Starting deploy'
                sh 'ssh -i ~/.ssh/id_sd enricu@10.1.1.13 /opt/deploy'
            }
       }
   } catch(error) {
       // Maybe some alerting?
       color = 'danger'
       slackSend color: color, message: 'Something bad happened!'
       throw error
   } finally {
       // Spin down containers no matter what happens
       slackSend color: color, message: 'Ending build'
       sh './develop down'
   }
}