var events = [
  {'Date': new Date(2018, 5, 5), 'Title': 'Press Meet 3:25pm.'},
  {'Date': new Date(2018, 5, 10), 'Title': 'Press Meet 5:25pm'},
  {'Date': new Date(2018, 4, 17), 'Title': 'Press Meet 3:00pm'},
];
var settings = {};
var element = document.getElementById('caleandar');
caleandar(element, events, settings);
