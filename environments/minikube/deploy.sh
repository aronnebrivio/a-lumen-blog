#!/bin/bash

echo 'Setup minikube'
minikube start
minikube -p minikube docker-env | source

echo 'Backup existing .env file'
cp .env .env.bak

echo 'Using production .env file'
cp environments/minikube/.env .env

# Docker build
echo 'Build Docker image'
docker build -t aronnebrivio/php:8.0-minikube -f environments/minikube/Dockerfile .

# minikube
echo 'Deploying to minikube'
kubectl apply -f environments/minikube/namespace.yaml
kubectl apply -f environments/minikube/data_tier.yaml -f environments/minikube/app_tier.yaml -n blog

echo 'Back to local .env file'
cp .env.bak .env

echo 'Start minikube tunnel'
minikube tunnel
