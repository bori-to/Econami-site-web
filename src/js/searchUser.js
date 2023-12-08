async function searchUser(){
	const input = document.getElementById('search_user_input');
	const name = input.value;
	let res;
	if (name === "" ) {
	window.location.reload();
} else {
	res = await fetch("api/search-user.php?name=" + name);
}
	const str = await res.text();
	const div = document.getElementById('users_list');
	console.log(str);
	div.innerHTML = str;
}

/*async function searchUser() {
  const input = document.getElementById('search_user_input');
  const name = input.value;
  
  // Vérifier si la valeur de la barre de recherche est vide
  if (name === '') {
    const res = await fetch("api/search-user.php");
    const str = await res.text();
    const div = document.getElementById('users_list');
    div.innerHTML = str;
    return;
  }
  
  const res = await fetch("api/search-user.php?name=" + name);
  const str = await res.text();
  const div = document.getElementById('users_list');
  div.innerHTML = str;
}*/