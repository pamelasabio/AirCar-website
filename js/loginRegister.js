        
$(document).click(function(event) {  
    if($('#loginbox').css('display') == 'block'){
        if(!($(event.target).closest('#loginForm').length) && !($(event.target).closest('#loginbtn').length) && !($(event.target).closest('#signInh1').length) ){
            //closeLoginTab();
            closeTheTab('loginbox'); 
        }
    }
    
    if($('#registerBox').css('display') == 'block'){
        if(!($(event.target).closest('#regForm').length) && !($(event.target).closest('#signubtn').length) && !($(event.target).closest('#signup').length) ) {
            //closeTab();
            closeTheTab('registerBox'); 
        }
    }
    
    if($('#profileBox').css('display') == 'block'){
        if(!($(event.target).closest('#updateForm').length) && !($(event.target).closest('#btn-change').length) && !($(event.target).closest('#btn-delete').length) && !($(event.target).closest('#editPassButton').length) ) {
            closeTheTab('profileBox'); 
        }
    }
});


// Register
       
function showTab(){
    document.getElementById('registerBox').style.display='block';
}

function closeTheTab(tabName){
    document.getElementById(tabName).style.display='none';
}

function callLoginTab(){
    closeTab();
    showLoginTab();
}

function callReg(){
    closeLoginTab();
    showTab();
}
        
function showLoginTab(){
    document.getElementById('loginbox').style.display='block';
}
