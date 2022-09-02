
function validation_mail()
{

    var masque_mail= /^\w+([.-]?\w+)@\w+([.-]?\w+)(\.\w{2,3})+$/;

    var mail= document.getElementById('mail').value;
    var mail2= document.getElementById('conf_mail').value;

    if(!masque_mail.test(mail) || mail !== mail2)
    {

        //afficher le nom en rouge

        document.getElementById('mail').className = 'form-control  text-danger';
        document.getElementById('conf_mail').className = 'form-control  text-danger';
        return false

    }
    else {
       document.getElementById('mail').className = 'form-control';
       document.getElementById('conf_mail').className = 'form-control';
       return true
    }
    
}

function validation_mdp()
{

    var masque_mdp= /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/;

    var mdp=document.getElementById('mdp').value;
    var mdp2=document.getElementById('conf_mdp').value;

    if(!masque_mdp.test(mdp) || mdp !== mdp2)
    {

        //afficher le nom en rouge

        document.getElementById('mdp').className = 'form-control text-danger';
        document.getElementById('conf_mdp').className = 'form-control  text-danger';
        return false

    }
    else {
        document.getElementById('mdp').className = 'form-control';
        document.getElementById('conf_mdp').className = 'form-control';
        return true
    }
// console.log(mdp)
}

function validation_mail_log()
{

    var masque_mail= /^\w+([.-]?\w+)@\w+([.-]?\w+)(\.\w{2,3})+$/;

    var mail= document.getElementById('mail').value;

    if(!masque_mail.test(mail))
    {

        //afficher le nom en rouge

        document.getElementById('mail').className = 'form-control  text-danger';
        return false

    }
    else {
       document.getElementById('mail').className = 'form-control';
       return true
    }
    
}

function validation_mdp_log()
{

    var masque_mdp= /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/;

    var mdp=document.getElementById('mdp').value;

    if(!masque_mdp.test(mdp))
    {

        //afficher le nom en rouge

        document.getElementById('mdp').className = 'form-control text-danger';
        return false

    }
    else {
        document.getElementById('mdp').className = 'form-control';
        return true
    }
// console.log(mdp)
}

function valid() 
{
    if(validation_mail() == true && validation_mdp() == true) {
        document.getElementById("formu").submit();
    }
    else {
        alert("IL Y A UNE COUILLEEEEE")
    }

}

function valid_log() 
{
    if(validation_mail_log() == true && validation_mdp_log() == true) {
        document.getElementById("formu").submit();
    }
    else {
        alert("IL Y A UNE COUILLEEEEE")
    }

}




// L'image img#image
var imageShow = document.getElementById("userPicture");
     
// La fonction previewPicture
var previewPicture  = function (e) {

    // e.files contient un objet FileList
    const [picture] = e.files

    // "picture" est un objet File
    if (picture) {
        // On change l'URL de l'image
        imageShow.src = URL.createObjectURL(picture)
    }
}  


var image = document.getElementById('saveButton')
// ????



image.addEventListener("click", requeteImg);

function requeteImg(){

    var pseudo = document.getElementById('pseudo').value;

    // Making the image file object
    var file = $('#imageButton').prop("files")[0];
    
    // Making the form object
    var form = new FormData();

    // Adding the image to the form
    form.append("image", file);
    form.append("pseudo", pseudo);
    
    
    $.ajax({
        url: "upload.php",
        type: "POST",
        data:  form ,
        dataType: 'json',
        contentType: false,
        processData:false,
        success: function(result){
            document.write(result);
        }
    });
}

// Drag and drop

$(function() {

    // preventing page from redirecting
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("h1").text("Drag here");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.image_class').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drag over
    $('.image_class').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drop
    $('.image_class').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $("h1").text("Upload");

  

        previewPicture();
    });

   
    
});






