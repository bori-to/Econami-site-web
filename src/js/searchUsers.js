async function searchUsers(){
	const input = document.getElementById('search_users_input');
	const name = input.value;
	const res = await fetch("api/search-users.php?name=" + name);
	const str = await res.text();
	const div = document.getElementById('users_list');
	console.log(str);
	div.innerHTML = str;
}

async function getUsers() {
	const res = await fetch("api/get_users.php");
	const str = await res.text();
	const div = document.getElementById('users_list');
	div.innerHTML = str;
}