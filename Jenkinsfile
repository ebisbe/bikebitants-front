#!/usr/bin/env groovy

node('master') {
    stage('build') {
        git url: 'git@bitbucket.org:bikebitants/bikebitants.git'

        // Start services (Let docker-compose build containers for testing)
        sh "./develop up -d"

        // Get composer dependencies
        sh "./develop composer install"

        // Create .env file for testing
        sh '/var/lib/jenkins/.venv/bin/aws s3 cp s3://bikebitants-secrets/env-ci .env'
        sh './develop art key:generate'
    }
    stage('test') {
        sh "APP_ENV=testing ./develop test"
    }
}