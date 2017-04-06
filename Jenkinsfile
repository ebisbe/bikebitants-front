#!/usr/bin/env groovy

node('master') {
   try {
       def color = 'good'
       def message = ''
       def user = ''
       stage('build') {
           slackSend color: color, message: "*${currentBuild.displayName}* on *'${BRANCH_NAME}'*"
           git url: 'git@bitbucket.org:bikebitants/bikebitants.git'

           showChangeLogs()

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
                curl -X POST 'https://api.newrelic.com/v2/applications/35571925/deployments.json' -H 'X-Api-Key:936c9599fc9827e0da37f0ba8c525afc51a58b46362766e' -i -H 'Content-Type: application/json' -d '{ \"deployment\": { \"revision\": \"${currentBuild.displayName}-${BRANCH_NAME}\", \"changelog\": \"${message}\", \"description\": \"Prod deploy\", \"user\": \"${user}\" } }'
            }
       }
   } catch(error) {
       // Maybe some alerting?
       color = 'danger'
       slackSend color: color, message: "Something bad happened! \n ${error}"
       throw error
   } finally {
       // Spin down containers no matter what happens
       slackSend color: color, message: 'Ending build'
       sh './develop down'
   }
}

@NonCPS
def showChangeLogs() {
  def changeLogSets = currentBuild.changeSets
  for (int i = 0; i < changeLogSets.size(); i++) {
     def entries = changeLogSets[i].items
     for (int j = 0; j < entries.length; j++) {
          def entry = entries[j]
          user = ${entry.author};
          message += " *${entry.msg}* on ${new Date(entry.timestamp)}\nBy ${entry.author} [${entry.commitId}]\n"
          def files = new ArrayList(entry.affectedFiles)
          for (int k = 0; k < files.size(); k++) {
              def file = files[k]
              message += "`${file.editType.name}: ${file.path}`\n"
          }
      }
  }
  slackSend color: 'warning', message: "${message}"
}