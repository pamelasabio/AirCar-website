var make = ["Any Make","Alfa Romeo","Audi","BMW","Fiat","Ford","Honda","Hyundai","Lexus","Mazda","Mercedes-Benz","Nissan","Opel","Peugeot","Seat","Volvo"];
        
var model = [
    ["Any Model"],
    ["Any Model","145","147","156","159","166","Alfasud","Brera","Giulietta","GT","Mito","Spider"],
    ["Any Model","80","100","A1","A2","A3","A4","A5","A6","A7","Q3","Q5","Q7","R8","RS4","RS5","RS6","S3","S4","S5","S8","TT","TTS"],
    ["Any Model","1-series","2-series","3-series","4-series","5-series","6-series","7-series","8-series","i3","i8","M3","M4","M5","M6","X1","X3","X4","X5","X6","Z3","Z4"],
    ["Any Model","125","126p","500","Bravo","Coupe","Punto","Uno"],
    ["Any Model","Anglia","B-MAX","Cargo","C-MAX","Cougar","ECOSPORT","Escort","Escort","Fiesta","Focus","GT","KA","Mondeo","Mustang","S-MAX","Transit"],
    ["Any Model","Accord","Civic","CR","FR","HR","Insight","Integra","Stepwagon"],
    ["Any Model","Accent","Amica","Coupe","i10","i20","i30","i40","i800","Montana","Sonata","Tucson"],
    ["Any Model","CT","GS","IS","LS","RX","SC","Soarer"],
    ["Any Model","1","2","3","5","6","CX-3","CX-5","CX-7","MPV","MX-3","MX-5","MX-6","RX-7","RX-8"],
    ["Any Model","190","200","220","230","240","250","280","300","320","350","380","500","600","A-Class","B-Class","C-Class","CE-Class","CL-Class","CLK-Class","CLS-Class","E-Class","G-Class","GLA","R-Class","S-Class","SLK-Class","V-Class"],
    ["Any Model","100 NX","103 NX","Almera","Cube","D21","D22","GT-R","Maxima","Micra","Pathfinder","Primera","Qashqai","Terrano","ZX"],
    ["Any Model","Adam","Astra","Corsa","Insignia","Omega","Tigra","Vectra","Zafira"],
    ["Any Model","106","107","205","208","306","405","508","605","807","Expert","ION","RCZ"],
    ["Any Model","Altea","Exeo","Ibiza","Leon","Malaga","MII","Toledo"],
    ["Any Model","200-series","400-series","700-series","900-series","C30","C70","S40","S70","S80","S90","V50","V60","V70","Xc60","Xc70","Xc90"]];

var modelNum = 0;

function InitializeMake(){
    var v = document.searchForm;
    v.makeSelect.options.length = null;

    for(var i = 0; i < make.length;i++){
        v.makeSelect.options[i] = new Option(make[i],i);
    }

    document.getElementById("makeHidden").value = make[0];
    document.getElementById("modelHidden").value = model[0][0];
}

 function ChangeModel(idx) {
    var f=document.searchForm;
    f.modelSelect.options.length=null;
    for(var i=0; i<model[idx].length; i++) {
        f.modelSelect.options[i]=new Option(model[idx][i], i); 
    }    
    document.getElementById("makeHidden").value = make[idx];
    modelNum = idx;
}

function SetModel(idx){
    document.getElementById("modelHidden").value = model[modelNum][idx];
}
