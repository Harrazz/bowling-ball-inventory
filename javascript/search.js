function searchTable() {
  const input = document.getElementById("searchInput");
  const filter = input.value.toUpperCase(); //retrieve input value to uppercase
  const table = document.getElementById("pageTable"); //retrieve table id in pagetable
  const tr = table.getElementsByTagName("tr"); //grab all table row

  // loop through table
  for (let i = 1; i < tr.length; i++) {
    const tds = tr[i].getElementsByTagName("td");
    let match = false;

    // checking for matches 
    for (let j = 0; j < tds.length; j++) {
      const td = tds[j];
      if (td && td.textContent.toUpperCase().includes(filter)) {
        match = true;
        break;
      }
    }

    // display zero row if nothing available
    tr[i].style.display = match ? "" : "none";
  }
}