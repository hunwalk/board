function createBoardAlert(apiPushKey, alertName, alertBody, type, keywords){

    let data = {
        apiPushKey,
        alertName,
        alertBody,
        type,
        keywords,
        sender: {
            name: 'board.js',
            version: 'v0.1',
        },
    }

    fetch('https://board.cstudios.ninja/api/v1/alert/push',{
        method: 'POST',
        cors: 'cors',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => response.json()).then(data => console.log(data));
}