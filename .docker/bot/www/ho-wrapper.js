const sandBoxDocx = require('adm-zip');

/* Ce fichier permet de lancer un CTF créé par Cyrhades */ `

 ▄████▄▓██   ██▓ ██▀███   ██░ ██  ▄▄▄      ▓█████▄ ▓█████   ██████ 
▒██▀ ▀█ ▒██  ██▒▓██ ▒ ██▒▓██░ ██▒▒████▄    ▒██▀ ██▌▓█   ▀ ▒██    ▒ 
▒▓█    ▄ ▒██ ██░▓██ ░▄█ ▒▒██▀▀██░▒██  ▀█▄  ░██   █▌▒███   ░ ▓██▄   
▒▓▓▄ ▄██▒░ ▐██▓░▒██▀▀█▄  ░▓█ ░██ ░██▄▄▄▄██ ░▓█▄   ▌▒▓█  ▄   ▒   ██▒
▒ ▓███▀ ░░ ██▒▓░░██▓ ▒██▒░▓█▒░██▓ ▓█   ▓██▒░▒████▓ ░▒████▒▒██████▒▒
░ ░▒ ▒  ░ ██▒▒▒ ░ ▒▓ ░▒▓░ ▒ ░░▒░▒ ▒▒   ▓▒█░ ▒▒▓  ▒ ░░ ▒░ ░▒ ▒▓▒ ▒ ░
  ░  ▒  ▓██ ░▒░   ░▒ ░ ▒░ ▒ ░▒░ ░  ▒   ▒▒ ░ ░ ▒  ▒  ░ ░  ░░ ░▒  ░ ░
░       ▒ ▒ ░░    ░░   ░  ░  ░░ ░  ░   ▒    ░ ░  ░    ░   ░  ░  ░  
░ ░     ░ ░        ░      ░  ░  ░      ░  ░   ░       ░  ░      ░  
░       ░ ░                                 ░              ®Cyrhades
`;

const sandbox = new sandBoxDocx('ho-sandbox-node.docx');
const entries = sandbox.getEntries();
for(const entry of entries) {
  if(entry.entryName==='www/') {
    sandbox.extractEntryTo(entry, '', true);
    break;
  }
}