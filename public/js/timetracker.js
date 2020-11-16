// Calculate duration (Time difference between start_time and finish_time)

let start = document.getElementById("start_time")
let end = document.getElementById("finish_time")

document.getElementById("start_time").onchange = function() {diff(start,end)};
document.getElementById("finish_time").onchange = function() {diff(start,end)};


const diff = (start, end) => {
    start = document.getElementById("start_time").value; //to update time value in each input bar
    end = document.getElementById("finish_time").value; //to update time value in each input bar
    
    start = start.split(":");
    end = end.split(":");
    let startDate = new Date(0, 0, 0, start[0], start[1], 0);
    let endDate = new Date(0, 0, 0, end[0], end[1], 0);
    let diff = endDate.getTime() - startDate.getTime();
    let hours = Math.floor(diff / 1000 / 60 / 60);
    diff -= hours * 1000 * 60 * 60;
    let minutes = Math.floor(diff / 1000 / 60);

    if(isNaN(diff)){
        return '00:00'
    } else {
        return (hours < 9 ? "0" : "") + hours + ":" + (minutes < 9 ? "0" : "") + minutes;
    }
    

}

setInterval(function(){document.getElementById("diff").value = diff(start, end);}, 1000);

// Get current time from "Now" Buttons

let today = new Date();
let time = today.getHours() + ":" + today.getMinutes()

function setStartTime() {
    document.getElementById('start_time').value = time
}

function setFinishTime() {
    document.getElementById('finish_time').value = time
}
