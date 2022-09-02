// --------------------------------------------------------------------------------------------------------------------------------------------
// ici on crée une variable 'tableau_des_messages' à laquelle on attribue un tableau contenant un objet par message échangé
// --------------------------------------------------------------------------------------------------------------------------------------------

let listContacts = [];
let contactId;
let listDiscussions = [];

let discussionId;
let messages = [];


// --------------------------------------------------------------------------------------------------------------------------------------------
// ici on va créer nos différents templates, qui seront ensuite injectés dans le code ElementAInjecter
// --------------------------------------------------------------------------------------------------------------------------------------------

const template_contact = `
<div class="container-fluid " onclick="openContact('%mail%')">
  <a href="#" class="d-flex flex-row align-items-center text-decoration-none p-3 hovergrey">
  <figure class="col-3 my-0">
    <img src="%url%" alt="" class="">
  </figure>
  <div class="col-9" >
    <div class="">
      <div class="d-flex justify-content-between">
        <h5 class="my-0 text-dark">%pseudo%</h5>
        </div>
      </div>
  </div>
  </a>
  <hr class="my-2 text-secondary">
</div>
`;

/* le template qui représente un contact dans la liste de message (gauche)*/
const template_interlocuteur_fiche = `
<div class="container-fluid " onclick="openMessage('%id%')">
  <a href="#" class="d-flex flex-row align-items-center text-decoration-none p-3 hovergrey">
  <figure class="col-3 my-0">
    <img src="%url%" alt="" class="">
  </figure>
  <div class="col-9" >
    <div class="">
      <div class="d-flex justify-content-between">
        <h5 class="my-0 text-dark">%conversationto%</h5>
        <small class="text-secondary">%date%</small>
        </div>
        <p class="my-0 text-secondary text-truncate" style="max-width:200px">%<i class="fa-solid fa-check-double"></i>%&nbsp;</i>%msg%</p>
      </div>
  </div>
  </a>
  <hr class="my-2 text-secondary">
</div>
`;

/* le template qui représente un message reçu (droite) */
const template_msg_reception = `
<div class="d-flex flex-column align-items-start">
  <div class="mb-3 p-3 bg-light bg-opacity-75 rounded-3" style="text-align: justify;">
    <p class="messageText text-dark mb-0" id="messagetext">%msg%</p>
    <small class="text-secondary text-end my-0" id="messagedate">%date%&nbsp;%<i class="fa-solid fa-check-double"></i>%</p></small>
  </div>
</div>
`;

/* le template qui représente un message envoyé (droite) */
const template_msg_envoi = `
<div class="d-flex flex-column align-items-end">
  <div class="mb-3 p-3 bg-success bg-opacity-25 rounded-3" style="text-align: justify;">
    <p class="messageText text-dark mb-0" id="messagetext">%msg%</p>
    <small class="text-secondary text-end my-0" id="messagedate">%date%&nbsp;%<i class="fa-solid fa-check-double"></i>%</small>
  </div>
</div>
`;

/* le template qui représente l'interlocuteur (droite) */
const template_titre_conversation = `
<div class="navbar-brand d-flex" href="#">
  <div class="d-flex align-items-center">
    <img src="%url%" alt="" class="petite_photo">
    </div>
  <div class="d-flex flex-column justify-content-center mx-2">
    <h2 class="text-white h4 my-0 color-change" id="destinataire">%conversationto%</h2>
    <small class="text-white fs-6 d-lg-none">Vu <span>%date%</span></small>
  </div>
</div>
`;




// --------------------------------------------------------------------------------------------------------------------------------------------
// ici on va créer nos différentes fonctions permmettant d'afficher le contenu
// --------------------------------------------------------------------------------------------------------------------------------------------

// on affiche la liste des messages (parti de gauche) celle de base
function show_discussions() {
  document.getElementById("msg-list").innerHTML = ""
  var liste = listDiscussions; //on récupère la fonction pour le nouveau tableau
  // permet de trier du plus récent au plus ancien
  liste.forEach((chat) => {
    var contact = findContact(chat.participants);
    //chat.last.send = chat.last.date;
    if (chat.read != null) {
      let ElementAInjecter = template_interlocuteur_fiche
        .replaceAll("%url%", contact.url)
        .replaceAll("%msg%", chat.last.msg)
        .replaceAll("%date%", fonction_tronquer_date(chat.last.date))
        .replaceAll("%id%", chat.id)
        .replaceAll("%conversationto%", contact.pseudo)
        .replaceAll(
          '%<i class="fa-solid fa-check-double"></i>%',
          '<i class="fa-solid fa-check-double text-info"></i>'
        );
      const DivElementCree = document.createElement("div");
      document.getElementById("msg-list").appendChild(DivElementCree);
      DivElementCree.outerHTML = ElementAInjecter;
    } else {
      let ElementAInjecter = template_interlocuteur_fiche
        .replaceAll("%url%", contact.url)
        .replaceAll("%msg%", chat.last.msg)
        .replaceAll("%id%", chat.id)
        .replaceAll("%date%", fonction_tronquer_date(chat.last.date))
        .replaceAll("%conversationto%", contact.pseudo)
        .replaceAll(
          '%<i class="fa-solid fa-check-double"></i>%',
          '<i class="fa-solid fa-check-double"></i>'
        );
      const DivElementCree = document.createElement("div");
      document.getElementById("msg-list").appendChild(DivElementCree);
      DivElementCree.outerHTML = ElementAInjecter;

    }
  });
};
// et on lance directment la fonction à partir d'ici.

function findContact(participants) {
  return listContacts.filter(contact => {
    for (var i = 0; i < participants.length; i++) {
      if (participants[i] == contact.mail) return true;
    }
    return false;
  }
  )[0];
}


// on affiche les messages recus (partie de droite)
function show_messages() {

  document.getElementById("conversations").innerHTML = ""; // permet de clean la div
  messages.forEach((chat) => {
    //chat.read = chat.date;
    //chat.send = chat.date;
    if (chat
      .author == me) {
      if (chat
        .read != null) {
        var ElementAInjecter = template_msg_envoi
          .replaceAll("%msg%", chat
            .msg)
          .replaceAll("%date%", fonction_tronquer_date(chat
            .date))
          .replaceAll(
            '%<i class="fa-solid fa-check-double"></i>%',
            '<i class="fa-solid fa-check-double text-info"></i>'
          );
      } else {
        var ElementAInjecter = template_msg_envoi
          .replaceAll("%msg%", chat
            .msg)
          .replaceAll("%date%", fonction_tronquer_date(chat
            .date))
          .replaceAll(
            '%<i class="fa-solid fa-check-double"></i>%',
            '<i class="fa-solid fa-check-double"></i>'
          );
      }
    } else {
      if (chat
        .read != null) {
        var ElementAInjecter = template_msg_reception
          .replaceAll("%msg%", chat
            .msg)
          .replaceAll("%date%", fonction_tronquer_date(chat
            .date))
          .replaceAll(
            '%<i class="fa-solid fa-check-double"></i>%',
            '<i class="fa-solid fa-check-double text-info"></i>'
          );
      } else {
        var ElementAInjecter = template_msg_reception
          .replaceAll("%msg%", chat
            .msg)
          .replaceAll("%date%", fonction_tronquer_date(chat
            .date))
          .replaceAll(
            '%<i class="fa-solid fa-check-double"></i>%',
            '<i class="fa-solid fa-check-double"></i>'
          );
      }
    }
    var DivElementCree = document.createElement("div"); // une variable qui cree un div
    document.getElementById("conversations").appendChild(DivElementCree);
    DivElementCree.outerHTML = ElementAInjecter;
    var x = document.getElementById("conversations"); // permet que le scroll commence en bas de la page
    x.scrollTop = x.scrollHeight; //fin scroll
  });
}


// --------------------------------------------------------------------------------------------------------------------------------------------
// nos différentes function pour manipuler les dates
// --------------------------------------------------------------------------------------------------------------------------------------------

// fonction qui permet de tronquer la date
function fonction_tronquer_date(date) {
  var d = new Date(date); //on initialise une variable date au format date avec le constructeur new date
  if (d.getDate() == new Date().getDate()) {
    //si la date en argument de la fonction est égale a la date du jour on retourne Aujourd hui + une partie de la chaine de caractere de la date du tableau
    return "aujourd'hui " + d.getHours() + ":" + d.getMinutes();
  } else return d.getDate() + "/" + d.getMonth() + " " + d.getHours() + ":" + d.getMinutes(); //sinon on renvoie la partie de la chaine de caractere qui correspond a année/mois/jour de la date du tableau
}

//function qui permet de mettre 'Date()-la date du jour' au format du tableau messages
function fonction_formater_date_actuelle() {
  var ActualDate = new Date();
  var send = "";
  var year = 1900 + ActualDate.getYear();
  var month = ActualDate.getMonth();
  var day = ActualDate.getDate();
  var hours = ActualDate.getHours();
  var minutes = ActualDate.getMinutes();
  var seconds = ActualDate.getSeconds();
  send =
    year +
    "-" +
    month +
    "-" +
    day +
    " " +
    hours +
    ":" +
    minutes +
    ":" +
    seconds;
  return send;
}


// --------------------------------------------------------------------------------------------------------------------------------------------
// nos différentes function pour récupérer la value tappé dans la barre de chat
// --------------------------------------------------------------------------------------------------------------------------------------------

function envoyer_message() {


  var mess = document.getElementById("chat").value; //on enregistre dans une variable "var mess" la valeur de l'input de la barre du chat
  if ((!contactId && !discussionId) || !mess) return;

  send_message(mess);
  document.getElementById("chat").value = "" // on vide la barre input à la fin quand le message est envoyé
}



function send_message(msg) {
  httpRequest = new XMLHttpRequest();
  var hostserver = "../api.oo.php?action=send_message";

  if (contactId) {
    // Nouvelle discussion
    hostserver += "&to=" + contactId;
  }
  else if (discussionId) {
    //Nouveau message
    hostserver += "&discussion_id=" + discussionId;
  }
  var post = JSON.stringify({ "msg": msg });
  httpRequest.open("POST", hostserver);
  httpRequest.setRequestHeader('Content-type', 'application/json; charset=UTF-8')

  httpRequest.onload = valide_message;
  httpRequest.send(post);
}


function valide_message() {
  var reponse = JSON.parse(httpRequest.responseText);
  console.log(reponse);
  if (reponse.discussion_id) {
    contactId = null;
    discussionId = reponse.discussion_id;
  }
  messages = reponse.discussion["messages"];
  show_messages();

}


// --------------------------------------------------------------------------------------------------------------------------------------------
// nos différentes function d'affichage
// --------------------------------------------------------------------------------------------------------------------------------------------
// fonction pour changer d'affichage : focus vue message
function openContact(mail) {
  contactId = mail;
  discussionId = null;
  messages = [];
  show_titre_contact();
  document.getElementById("viewList").classList.replace("d-flex", "d-none");
  document.getElementById("viewMessages").classList.replace("d-none", "d-flex");
  //Verifier si une discussion existe 
  var discussions_ = listDiscussions.filter(discussion => {
    for (var i = 0; i < discussion["participants"].length; i++) {
      if (discussion["participants"][i] == mail) return true;
    }
    return false;
  }
  );
  if (discussions_.length == 1) {
    discussionId = discussions_[0].id;
    contactId = null;
    get_messages(discussionId);
  }
  show_messages();
}

// on affiche l'interlocuteur (partie de droite)
function show_titre_contact() {

  var contact = listContacts.filter(contact => contact.mail == contactId)[0];

  document.getElementById("interlo").innerHTML = ""; // permet de clean la div
  var ElementAInjecter = template_titre_conversation
    .replaceAll("%url%", contact.url)
    .replaceAll("%date%", "")
    .replaceAll("%conversationto%", contact.pseudo);
  var DivElementCree = document.createElement("div");
  document.getElementById("interlo").appendChild(DivElementCree);
  DivElementCree.outerHTML = ElementAInjecter;

}

// fonction pour changer d'affichage : focus vue message
function openMessage(id) {

  discussionId = id;
  messages = [];
  contactId = null;
  get_messages(discussionId);
  show_messages();
  document.getElementById("viewList").classList.replace("d-flex", "d-none");
  document.getElementById("viewMessages").classList.replace("d-none", "d-flex");
}
// fonction pour changer d'affichage : retour vue liste
function backToList() {
  document.getElementById("viewList").classList.replace("d-none", "d-flex");
  document.getElementById("viewMessages").classList.replace("d-flex", "d-none");
}

// fonction pour changer d'affichage : mode dark
const options = {
  bottom: "10px", // default: '32px'
  right: "unset", // default: '32px'
  left: "15px", // default: 'unset'
  time: "0.5s", // default: '0.3s'
  mixColor: "#fff", // default: '#fff'
  backgroundColor: "#fff", // default: '#fff'
  buttonColorDark: "#198754", // default: '#100f2c'
  buttonColorLight: "#E678AB", // default: '#fff'
  saveInCookies: false, // default: true,
  label: "🌓", // default: ''
  autoMatchOsTheme: true, // default: true
};
const darkmode = new Darkmode(options);


// --------------------------------------------------------------------------------------------------------------------------------------------
// enfin une checklist pour lister les fonctionnalités
// --------------------------------------------------------------------------------------------------------------------------------------------
function init() {
  //get_message()
  get_contacts();
  get_discussions();

  refresh();

  //fonction_afficher_liste_interlocuteurs();

  // Ajout d'une simulation de click, avec la touche entrée
  var input = document.getElementById("chat");
  // execute une fonction quand l'utilisateur appuye sur le clavier
  input.addEventListener("keypress", function (event) {
    // si l'utilisateur appuye sur la touche "Enter"
    if (event.key === "Enter") {
      // annuel l'action par default, si besoin
      event.preventDefault();
      // ça simule le click sur un boutton
      document.getElementById("envoyer_message").click();
    }
  });


  darkmode.showWidget();
  window.addEventListener("load", addDarkmodeWidget);
}


function get_contacts() {
  var httpRequest = new XMLHttpRequest();
  var hostserver = "../api.oo.php?action=get_contacts";
  httpRequest.open("GET", hostserver);
  httpRequest.onload = () => {
    listContacts = JSON.parse(httpRequest.responseText);
    show_contacts();
  };
  httpRequest.send();
}




function show_contacts() {
  document.getElementById("msg-list").innerHTML = "";
  var liste = listContacts; //on récupère la fonction pour le nouveau tableau
  liste.sort((a, b) => (a.pseudo > b.pseudo ? -1 : 1)); // permet de trier du plus récent au plus ancien
  liste.forEach((user) => {

    let ElementAInjecter = template_contact
      .replaceAll("%url%", user.user_img)
      .replaceAll("%pseudo%", user.pseudo)
      .replaceAll("%mail%", user.mail);
    const DivElementCree = document.createElement("div");
    document.getElementById("msg-list").appendChild(DivElementCree);
    DivElementCree.outerHTML = ElementAInjecter;

  });
}



function affiche_messages() {
  console.log(httpRequest)
  console.log(httpRequest.responseText)
  tableau_des_messages = JSON.parse(httpRequest.responseText);
  fonction_afficher_liste_interlocuteurs();
  fonction_afficher_titre_conversation(conversationto);
  fonction_afficher_conversation(conversationto);
}
function checklist() {
  var check = `Checklist :
  Design responsive.
  A GAUCHE : Liste des interlocuteurs avec dernier message. Ordonnés par date décroissante.
  A DROITE : Generation de l'ensemble des messages relatifs aux conversations. Ordonnés par date croissante.
  Barre de chat active : rajoute un message avec date dans la bonne discussion.
  Rajout de l'option touche "entrée" avec la barre de chat. 
  Check sur le "read" des messages.
  Troncage des dates (plus de 24h).
  Darkmode disponible
 `;
  return alert(check);
}


function get_discussions() {
  var httpRequest = new XMLHttpRequest();
  var hostserver = "../api.oo.php?action=get_discussions";
  httpRequest.open("GET", hostserver);
  httpRequest.onload = () => {
    listDiscussions = JSON.parse(httpRequest.responseText);
    listDiscussions.sort((a, b) => (a.last.date > b.last.date ? -1 : 1));
    show_discussions();
    console.log(listDiscussions);
  };
  httpRequest.send();
}

function get_messages() {
  var httpRequest = new XMLHttpRequest();
  var hostserver = "../api.oo.php?action=get_messages&discussion_id=" + discussionId;
  httpRequest.open("GET", hostserver);
  httpRequest.onload = () => {
    messages = JSON.parse(httpRequest.responseText)["messages"];
    show_messages();

  };
  httpRequest.send();
}

function refresh() {
  var httpRequest = new XMLHttpRequest();
  var hostserver = "../api.oo.php?action=refresh";
  if (discussionId) {
    hostserver += "&discussion_id=" + discussionId;
  }
  httpRequest.open("GET", hostserver);
  httpRequest.onload = () => {
    var reponse = JSON.parse(httpRequest.responseText);

    var old = JSON.stringify(listDiscussions);
    listDiscussions = reponse["discussions"];
    listDiscussions.sort((a, b) => (a.last.date > b.last.date ? -1 : 1));
    if (old != JSON.stringify(listDiscussions)) {
      console.log(old)
      console.log(JSON.stringify(listDiscussions))
      show_discussions();
    }
    if (discussionId) {
      old = JSON.stringify(messages);
      messages = reponse["messages"];
      if (old != JSON.stringify(messages)) {
        console.log(old)
        console.log(JSON.stringify(messages))
        show_messages();
      }
    }
    setTimeout(refresh, 10000);
  };
  httpRequest.send();
}
