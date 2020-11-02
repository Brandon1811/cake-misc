#!/bin/bash
mysql -u jenkins -pcakephp_jenkins -e 'DROP DATABASE IF EXISTS cakephp_test; CREATE DATABASE cakephp_test';

