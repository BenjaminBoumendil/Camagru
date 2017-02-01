.PHONY: install clean

PROJECT_DIR = ~/Project/Camagru

VHOST_NAME = camagru-vhost.conf
VHOST_DIR_SOURCE = $(PROJECT_DIR)/$(VHOST_NAME)
VHOST_DIR_TARGET = /usr/local/PAMP/apache/conf/perso

SETUP_FILE = $(PROJECT_DIR)/config/setup.php
UNSET_FILE = $(PROJECT_DIR)/config/unset.php

install:
	@ln -sf $(VHOST_DIR_SOURCE) $(VHOST_DIR_TARGET)


clean:
	@rm -rf $(VHOST_DIR_TARGET)/$(VHOST_NAME)
