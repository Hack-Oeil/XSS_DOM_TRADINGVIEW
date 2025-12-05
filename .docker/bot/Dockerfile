FROM node:20-slim

RUN apt-get update && apt-get install -y sudo wget unzip
RUN npm install -g npm@11.4.2 wscat

# Création d'un utilisateur non privilégié et ajout au groupe sudo
RUN useradd -m chromeuser && echo "chromeuser ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers.d/nopasswd && usermod -aG sudo chromeuser

# installation de chrome
RUN wget "https://chrome-versions.com/google-chrome-stable-114.0.5735.198-1.deb"
RUN dpkg -i --ignore-depends=package-name /google-chrome-stable-114.0.5735.198-1.deb || true
RUN apt-get --fix-broken install -y
RUN dpkg -i /google-chrome-stable-114.0.5735.198-1.deb
RUN rm /google-chrome-stable-114.0.5735.198-1.deb

# Récupération de la dernier version de chromedriver compatible avec notre version chrome
# https://chromedriver.storage.googleapis.com/LATEST_RELEASE_${VERSION}
RUN export VERSION=$(google-chrome-stable --version | cut -d ' ' -f 3 | cut -d '.' -f 1) && \
    export LATEST_RELEASE=$(wget -qO - "https://chromedriver.storage.googleapis.com/LATEST_RELEASE_114") && \
    wget -O /tmp/chromedriver_linux64.zip "https://chromedriver.storage.googleapis.com/$LATEST_RELEASE/chromedriver_linux64.zip" && \
    unzip /tmp/chromedriver_linux64.zip -d /usr/local/bin/ && \
    chmod +x /usr/local/bin/chromedriver


WORKDIR /home/www
COPY ./www /home/


RUN cd ../ && npm install adm-zip && node /home/ho-wrapper.js
RUN cd /home/www && npm install
