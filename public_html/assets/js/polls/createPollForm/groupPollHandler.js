var groupPoll = document.getElementById('groupPoll');
var groupPollOptions = document.getElementById('groupPollOptions');

groupPoll.addEventListener('click', function() {
    groupPollOptions.style.display = "block";
});

var publicPoll = document.getElementById('publicPoll');

publicPoll.addEventListener('click', function() {
    groupPollOptions.style.display = "none";
});