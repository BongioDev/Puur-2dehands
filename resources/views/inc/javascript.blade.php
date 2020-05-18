<script>
    function priceclass(){

        var prijs = document.getElementById("prijs");

       if(document.getElementById('vraagprijs').selected == true){
           prijs.readOnly = false;
           prijs.value = "";
       }
       if(document.getElementById('bieden').selected == true){
           prijs.readOnly = false;
           prijs.value = "Bieden vanaf: € ";
       }
       if(document.getElementById('otk').selected == true){
           prijs.value = "Prijs overeen te komen";
           prijs.readOnly = true;
       }
       if(document.getElementById('ruilen').selected == true){
           prijs.value = "Ruilen";
           prijs.readOnly = true;
       }
       if(document.getElementById('gratis').selected == true){
           prijs.value = "Gratis";
           prijs.readOnly = true;
       }
   }
</script>