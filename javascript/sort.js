
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("pageTable");
    switching = true; //keep sorting active

    dir = "asc"; //default sorting order

    while (switching) {
        // keep sorting and fetchs all tbale row
        switching = false;
        rows = table.rows;

        // loop through rows
        for (i = 1; i < (rows.length - 1); i++) {

            shouldSwitch = false;

            // compare current row with next row
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {

                    // mark a switch and break the loop
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {

                    // mark a switch and break the loop
                    shouldSwitch = true;
                    break;
                }
            }
        }

        // row swap
        if (shouldSwitch) {

            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;

            // each time switch done, increase this count by 1
            switchcount++;
        } else {

            // if no switching been done and direction is asc, set the direction to desc and run loop again
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}