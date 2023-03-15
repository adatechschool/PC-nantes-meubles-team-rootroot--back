function fetchData(){
    start = performance.now();
    return fetch("http://127.0.0.1:8000/getMeuble")
    .then((result) => {
        //console.log("something is here")
      return result.json();
    })
    .catch((error) => {
      console.log(`error on api: ${error}`);
    });

}
function showData(){
  fetchData().then((response)=>{
        console.log(response)
  })
}
showData()