Au début :
    -La version Desktop affiche directement la dernière conversation, dernier message reçu ou envoyé.
    Quand on sélectionne le dernier message d'une conversation à droite, elle s'affiche à gauche.
    -La version Mobile affiche uniqement les derniers messages envoyés ou reçus.
     Quand on sélectionne le dernier message, la conversation s'affiche entièrement. (On est sur la même page!!) 


La zone recherche, et la zone de saisie doivent être des vrais champs de saisie (input)

. Vous aurez donc 2  fonction d'affichage : 
    - affichage des dernières conversations 
    - affichage de la conversation sélectionnée
Il faudra donc filtrer !! (ne pas afficher tous les messages !!!!!!   ) 

Travaillez dans les salons par groupe !!!!!
Le travail doit ête rendu par chacun !!!!!


Pour les plus avancées : 
 - Activer la fonction de recherche ! il faut rechercher dans les messages le texte recherché
 - Ajouter des messages avec la zone de saisie de la conversation
 - Version dark mode / fichier dark.css



1.Votre variable de chat

var messages =[
    { conversationto: "yasmina" ,url:"https://benmalem-yasmina.e-osengo.fr/img/user.jpg",name:"yasmina",
        send: "2022-06-20 07:00:00",received:"2022-06-20 07:00:02",read:"2022-06-20 10:00:00",
        author:"yasmina",msg:"Hello" },
    { conversationto: "yasmina" ,url:"https://benmalem-yasmina.e-osengo.fr/img/user.jpg",name:"yasmina",
        send: "2022-06-20 06:50:00",received:"2022-06-20 06:50:02",read:"2022-06-20 06:53:00",
        author:"moi",msg:"Coucou" },
    { conversationto: "antonio" ,url:"https://teixeira-de-abreu-antonio.e-osengo.fr/img/user.jpg",name:"antonio",
        send: "2022-06-20 07:00:00",received:"2022-06-20 07:00:02",read:"2022-06-20 10:00:00",
        author:"antonio",msg:"Ça va et toi ?" },
    { conversationto: "antonio" ,url:"https://teixeira-de-abreu-antonio.e-osengo.fr/img/user.jpg",name:"antonio",
        send: "2022-06-20 06:50:00",received:"2022-06-20 06:50:02",read:"2022-06-20 06:53:00",
        author:"moi",msg:"Coucou" },
    { conversationto: "vincent" ,url:"https://vaugrente-vincent.e-osengo.fr/img/user.jpg",name:"vincent",
        send: "2022-06-20 07:00:00",received:"2022-06-20 07:00:02",read:"2022-06-20 10:00:00",
        author:"yasmina",msg:"Hello" },
    { conversationto: "vincent" ,url:"https://vaugrente-vincent.e-osengo.fr/img/user.jpg",name:"vincent",
        send: "2022-06-20 06:50:00",received:"2022-06-20 06:50:02",read:"2022-06-20 06:53:00",
        author:"moi",msg:"Coucou" },
    { conversationto: "kevin" ,url:"https://lignon-kevin.e-osengo.fr/img/user.jpg",name:"kevin",
        send: "2022-06-20 06:34:00",received:"2022-06-20 06:34:02",read:null,
        author:"kevin",msg:"Gros naze, je préfère de loin la série Dora à la recherche de la clé privée SSL de shein.com, elle est vraiment badass 😎"},
    { conversationto: "kevin" ,url:"https://lignon-kevin.e-osengo.fr/img/user.jpg",name:"kevin",
        send: "2022-06-20 06:33:00",received:"2022-06-20 06:33:02",read:"2022-06-20 06:33:30",
        author:"moi",msg:"La série Oui-oui upgrade son site web en regex est top, je te la conseille grave !  😁 " },
    { conversationto: "kevin" ,url:"https://lignon-kevin.e-osengo.fr/img/user.jpg",name:"kevin",
        send: "2022-06-20 06:32:00",received:"2022-06-20 06:32:02",read:"2022-06-20 06:32:30",
        author:"kevin",msg:"Hello" },
    { conversationto: "kevin" ,url:"https://lignon-kevin.e-osengo.fr/img/user.jpg",name:"kevin",
        send: "2022-06-20 06:31:00",received:"2022-06-20 06:31:02",read:"2022-06-20 06:31:30",
        author:"moi",msg:"Coucou" }
    ];

/// Vous pouvez ajouter ou modifier les messages à foison !!! 
/// Il faut par contre respecter le format des dates, et leur ordre : send <received < read





2.// Fonctions de tri  exemples
// On peut trier naturelement des nombres, du texte, et des dates, les objets ne sont pas comparables directement, il faudra utiliser des fonctions de comparaison
var tvseries = [ { titre:"game of thrones", note:9.5  },{titre:"walking dead", note:8.9 },{ titre:"the boys", note:9.0 },{titre:"peaky blinders",note:8.3} ];
// Fonction de Tri par ordre alphabétique des titre 
function comparaison_titre(serie1,serie2)
{
    if (serie1.titre>serie2.titre) return -1;
    else    return 1;
}
// Fonction  de Tri du mieux noté au moins noté
function comparaison_notee(serie1,serie2)
{
    if (serie1.note>serie2.note) return -1;
    else    return 1;
}
// On peut intervertir les -1 et les 1, pour changer l'ordre de tri

// là on trie par titre, le tableau tvseries sera trié par titre
tvseries.sort(comparaison_titre)



3. Les objets Dates

var date_maintenant = Date.now()   // la date de maintenant

var strDate="2022-06-20 07:00:00"
var date = new Date(strDate)
var year = date.getYear() // année
var day = date.getDate() // jour du mois
var hours = date.getHours() // heures
var minutes = date.getMinutes() // minutes
var month = date.getMonth() // month      0-11
// Il est également possible de comparer 2 dates entre elles

https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/Date


Ressources pour trouver des icônes sympas
https://fontawesome.com/icons

