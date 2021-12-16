function ordenaTabla(tabla)
{
  cabecera = tabla.children[0].children[0].children;
  for(i=0;i<cabecera.length;i++)
  {
      cabecera[i].addEventListener("click",function(){
          n_columna = this.cellIndex;
          ordena(n_columna,tabla);
      })
  }
}
function ordena(n,tabla) {
    var tabla, filas, inte, i, x, y, ordena, dir, inteCont = 0;
   
    inte = true;
    dir = "asc";
   
    while (inte)
    {
      inte = false;
      filas = tabla.rows;
      
      for (i = 1; i < (filas.length - 1); i++)
      {
        ordena = false;
        
        x = filas[i].getElementsByTagName("TD")[n];
        y = filas[i + 1].getElementsByTagName("TD")[n];
      
        if(dir == "asc")
        {
          if((x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()))
          {
            ordena= true;
            break;
          }
        }
        else if (dir == "desc")
        {
          if((x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()))
          {
            ordena = true;
            break;
          }
        }
      }
      if(ordena)
      {
        filas[i].parentNode.insertBefore(filas[i + 1], filas[i]);
        inte = true;
        inteCont ++;
      }
      else{
    
        if(inteCont == 0 && dir == "asc")
        {
          dir = "desc";
          inte = true;
        }
      }
    }
  }