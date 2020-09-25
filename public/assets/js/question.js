class Question {

    apiUrl = 'http://localhost:8000/api/question';
    browseEndpoint = '/browse';
    fetchOption = {
        method: 'GET',
        mode: 'cors',
        cache: 'no-cache'
    };

    load() {
        const request = fetch(this.apiUrl+this.browseEndpoint, this.fetchOption);
        request.then((response) => {
              return response.json();
            }).then((jsonResponse) => {
                this.questions = jsonResponse;
            }
          );
    }
}

// Exemple of class structure
// constructor(height, width) {
//   this.height = height;
//   this.width = width;
// }
// // Getter
// get area() {
//     return this.calcArea();
// }
// // Method
// calcArea() {
//     return this.height * this.width;
// }