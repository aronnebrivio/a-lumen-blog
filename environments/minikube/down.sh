#!/bin/bash

kubectl delete -n blog all --all
kubectl delete -n blog pvc --all
kubectl delete -n blog cm --all
kubectl delete pv --all

kubectl delete namespace blog
