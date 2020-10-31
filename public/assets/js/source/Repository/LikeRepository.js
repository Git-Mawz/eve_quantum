class LikeRepository
{
    constructor() {
        console.log('LikeRepository Loaded')
    }

    endPoints = {
        toggleLike : '/api/like/toggle/',
    }

    toggleLike(answerId){
        let options = {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            mode: 'cors',
            cache: 'no-cache'
        };


        return fetch(this.endPoints.toggleLike + answerId, options).then((response) => {
            return response.json()
        });

    }

}