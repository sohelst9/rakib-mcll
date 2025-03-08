function SetGlobalVariable(YourReward) {

    var urlString = window.location.href;
    var url = new URL(urlString);

    var user_id = url.searchParams.get("user_id"); // Assuming user_id is passed as a query parameter
    var game_id = url.searchParams.get("game_id"); // Assuming you are using a static game_id

    // Constructing the returnDataUrl with user_id and game_id
//     const returnDataUrl = `http://127.0.0.1:8000/api/tournament/score?game_id=${game_id}&user_id=${user_id}&score=${YourReward}`;
    const returnDataUrl = `https://dashboard.playmcll.com/api/tournament/score?game_id=${game_id}&user_id=${user_id}&score=${YourReward}`;
    // Sending the GET request with the correct parameters
    fetch(returnDataUrl, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        // Handle the data if needed
        console.log(data);
    })
    .catch((error) => {
        // Handle errors
        console.error('Error:', error);
    });
}




const scriptsInEvents = {

	async Game_events_Event54_Act3(runtime, localVars)
	{
		console.log("score is : ",runtime.globalVars.Score)
	},

	async Game_events_Event54_Act4(runtime, localVars)
	{
		SetGlobalVariable(runtime.globalVars.Score)
	}

};

self.C3.ScriptsInEvents = scriptsInEvents;

