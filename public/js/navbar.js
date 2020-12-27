  // Add Event To btn 
  document.getElementById('btn').addEventListener('click', function()
  {
      // Change The Display Of Navbar from bolck to none
      if( document.getElementById('navbarsExampleDefault').style.display == "block")
        document.getElementById('navbarsExampleDefault').style.display = "none";
      else
        document.getElementById('navbarsExampleDefault').style.display = "block";
  });