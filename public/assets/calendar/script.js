  $(".deselect-date").on("click", function (e) {
    $(".wrap").removeClass("date-selected slot-selected");
    $(".calendar *").removeClass("selected");
    e.preventDefault();
    e.stopPropagation();
  });
  
  $(".deselect-slot").on("click", function (e) {
    $(".wrap").removeClass("slot-selected");
    $(".slots *").removeClass("selected");
    e.preventDefault();
    e.stopPropagation();
  });
  
  
  function invokeSlotsListener() {
    $(".slots li").on("click", function (e) {
      $(this).addClass("selected");
      $(".wrap").addClass("slot-selected");
      setTimeout(function () {
        $('.selected.member input[name="name"]').focus();
      }, 700);
      e.preventDefault();
      e.stopPropagation();
    });
  }
  
  function invokeCalendarListener() {
    $(".calendar td:not(.disabled)").on("click", function (e) {
      var date = $(this).html();
      var day = $(this).data("day");
      var month = $("#month").html();
      var year = $("#year").html();
      var completeDate = new Date(date+' '+month+' '+year);
      
      addSlots(completeDate.toDateString());
      
      $(".date").html(day + ",  " + date);
      $(this).addClass("selected");
      setTimeout(function () {
        $(".wrap").addClass("date-selected");
      }, 10);
      e.preventDefault();
      e.stopPropagation();
    });
  }
  var monthNamesFull = [ "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December" ];
  
  function addCalendar(container, days, dateFrom, dateTo, monthPass, firstMonth) {
    var today = new Date();
    var from = new Date(dateFrom);
    var to = new Date(dateTo);
    var fullDate = new Date();
    var arr;
    var arr2;
    arr2 = diff(firstMonth, to);
    firstMonth = monthNamesFull[firstMonth.getMonth()] + ' '+firstMonth.getFullYear();
    if(from > today){
      var date = from.getDate();
      var month = from.getMonth();
      var year = from.getFullYear();
      fullDate = from;
      arr = diff(from, to);
    }
    else{
      var date = today.getDate()+1;
      var month = today.getMonth();
      var year = today.getFullYear();
      fullDate = new Date();
      fullDate = fullDate.setDate(fullDate.getDate() + 1);
      arr = diff(today, to);
    }
    fullDate = new Date(fullDate);
    var first = new Date(fullDate);
    first.setDate(1);
    var startDay = first.getDay();
    var dayLabels = ["S", "M", "T", "W", "T", "F", "S"];
    var allDays = [];
    for(var i = 0; i <= days.length; i++){
      switch(days[i]){
        case "monday": 
          allDays.push(1);  
          break;
        case "tuesday": 
          allDays.push(2);  
          break;
        case "wednesday": 
          allDays.push(3);  
          break;
        case "thursday": 
          allDays.push(4);  
          break;
        case "friday": 
          allDays.push(5);  
          break;
        case "saturday": 
          allDays.push(6);  
          break;
        case "sunday": 
          allDays.push(0);  
          break;
      }
    }

    var monthNames = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec"
    ];
    var daysMonth=[31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
    var dayNames = ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"];
    var current = 1 - startDay;
    //assemble calendar
    var calendar =
      '<label class="date" id="date"></label><label class="month" id="month">' +
      monthNames[month] +
      '</label> <label class="year" id="year">' +
      year +
      "</label>";
      if(arr2.length == 1){
        calendar += "<span class='deselect-angle disableAngle' disabled='true'><i class='fa fa-angle-right' style='font-size:22px' ></i>&nbsp;&nbsp;</span><span class='deselect-angle mr-5 disableAngle' disabled='true'><i class='fa fa-angle-left' style='font-size:22px'></i>&nbsp;</span>";
      }
      else if(arr.length == 1){
        calendar += "<span class='deselect-angle disableAngle' disabled='true'><i class='fa fa-angle-right' style='font-size:22px' ></i>&nbsp;&nbsp;</span><span class='deselect-angle mr-5' data-id='"+arr2[arr2.length-2]+"'><i class='fa fa-angle-left' style='font-size:22px'></i>&nbsp;</span>";
      }
      else if(arr[0] == firstMonth){
        calendar += "<span class='deselect-angle' data-id='"+arr[1]+"'><i class='fa fa-angle-right' style='font-size:22px' ></i>&nbsp;&nbsp;</span><span class='deselect-angle mr-5 disableAngle' disabled='true'><i class='fa fa-angle-left' style='font-size:22px'></i>&nbsp;</span>";
      }
      else{
        var index = arr2.findIndex(element => element === arr[0]);
        calendar += "<span class='deselect-angle' data-id='"+arr2[index+1]+"'><i class='fa fa-angle-right' style='font-size:22px' ></i>&nbsp;&nbsp;</span><span class='deselect-angle mr-5' data-id='"+arr2[index-1]+"'><i class='fa fa-angle-left' style='font-size:22px'></i>&nbsp;</span>";
      }

  
    calendar += "<table><tr>";
    dayLabels.forEach(function (label) {
      calendar += "<th>" + label + "</th>";
    });
    calendar += "</tr><tr>";
    var dayClasses = "";
    while (current <= daysMonth[month]) {
      if (current > 0) {
        dayClasses = "";
        fullDate.setDate(current);
        if (!(allDays.includes(fullDate.getDay(), 0))) {
          dayClasses += " disabled";
        }
        if (current < date) {
          dayClasses += " disabled";
        }
        if(fullDate.getMonth() == to.getMonth()){         
          if (current > to.getDate()) {
            dayClasses += " disabled";
          }
        }
        // if (current == date) {
        //   dayClasses += " today";
        // }
        calendar +=
          '<td class="' +
          dayClasses +
          '" data-day="' +
          dayNames[(current + startDay) % 7] +
          '">' +
          current +
          "</td>";
      } else {
        calendar += "<td></td>";
      }
  
      if ((current + startDay) % 7 == 0) {
        calendar += "</tr><tr>";
      }
  
      current++;
    }
  
    calendar += "</tr></table>";
    container.html(calendar);
    if(from.getMonth() == monthPass){
      $('.left').prop('disabled', 'true');
      $('.left').css('pointer-events', 'none');
      
    }
    invokeCalendarListener();
  }
  
    
  function diff(from, to) {
      var arr = [];
      var datFrom = new Date(from);
      var datTo = new Date(to);
      var fromYear =  datFrom.getFullYear();
      var toYear =  datTo.getFullYear();
      var diffYear = (12 * (toYear - fromYear)) + datTo.getMonth();
  
      for (var i = datFrom.getMonth(); i <= diffYear; i++) {
          arr.push(monthNamesFull[i%12] + " " + Math.floor(fromYear+(i/12)));
      }        
      return arr;
  }