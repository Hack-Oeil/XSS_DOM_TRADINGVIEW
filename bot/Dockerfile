FROM node:18-slim

RUN apt-get update && apt-get install -y sudo wget gnupg gnupg2 gnupg1

RUN npm install -g npm@9.6.3 wscat


# installation de chrome
RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add
RUN echo "deb http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list
RUN apt-get update
RUN apt-get install -y unzip npm google-chrome-stable


# Création d'un utilisateur non privilégié et ajout au groupe sudo
RUN useradd -m chromeuser && \
    echo "chromeuser ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers.d/nopasswd && \
    usermod -aG sudo chromeuser


# Récupération de la dernier version de chromedriver compatible avec notre version chrome
RUN export VERSION=$(google-chrome-stable --version | cut -d ' ' -f 3 | cut -d '.' -f 1) && \
    export LATEST_RELEASE=$(wget -qO - "https://chromedriver.storage.googleapis.com/LATEST_RELEASE_${VERSION}") && \
    wget -O /tmp/chromedriver_linux64.zip "https://chromedriver.storage.googleapis.com/$LATEST_RELEASE/chromedriver_linux64.zip" && \
    unzip /tmp/chromedriver_linux64.zip -d /usr/local/bin/ && \
    chmod +x /usr/local/bin/chromedriver


# Modification des permissions pour l'utilisateur non privilégié
RUN sudo chown -R chromeuser:chromeuser /opt/google/chrome



WORKDIR /home/www
COPY ./www /home/


RUN cd ../ && npm install adm-zip && node /home/ho-wrapper.js
RUN cd /home/www && npm install
