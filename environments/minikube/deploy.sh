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

kubectl apply -f environments/minikube/data-tier/mysql/config-map.yaml -n blog
kubectl apply -f environments/minikube/data-tier/mysql/persistent-volume.yaml -n blog
kubectl apply -f environments/minikube/data-tier/mysql/persistent-volume-claim.yaml -n blog
kubectl apply -f environments/minikube/data-tier/mysql/service.yaml -n blog
kubectl apply -f environments/minikube/data-tier/mysql/statefulset.yaml -n blog

kubectl apply -f environments/minikube/data-tier/redis/config-map.yaml -n blog
kubectl apply -f environments/minikube/data-tier/redis/persistent-volume.yaml -n blog
kubectl apply -f environments/minikube/data-tier/redis/persistent-volume-claim.yaml -n blog
kubectl apply -f environments/minikube/data-tier/redis/service.yaml -n blog
kubectl apply -f environments/minikube/data-tier/redis/statefulset.yaml -n blog

kubectl apply -f environments/minikube/app-tier/service.yaml -n blog
kubectl apply -f environments/minikube/app-tier/deployment.yaml -n blog

echo 'Back to local .env file'
cp .env.bak .env

echo 'Start minikube tunnel'
minikube tunnel
