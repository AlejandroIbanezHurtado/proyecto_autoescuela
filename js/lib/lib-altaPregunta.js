window.addEventListener("load",function(){
    var imagenPre = document.getElementById("imagenPre");
    var subir = document.getElementById("subir");
    var imagenPre = document.getElementById("imagenPre");
    if(imagenPre.getAttribute("value")!=null && imagenPre.getAttribute("value")!="")
    {
        imagenPre.style.backgroundImage = "url('"+imagenPre.getAttribute("value")+"')";
    }
    subir.addEventListener("change",function(){
        readFile(this);
    })
})
function readFile(input) {
    let file = input.files[0];
    let reader = new FileReader();
    reader.readAsDataURL(file);
    
    reader.onload = function() {
        imagenPre.style.backgroundImage = "url('"+reader.result+"')";
    };
    
    reader.onerror = function() {
        console.log(reader.error);
    };
  
}