export async function checkSession() {
  const res = await fetch('../check-session.php');
  const data = await res.json();
  const formData = new FormData();

  if (data.loggedIn) {
    const token = localStorage.getItem("session")
    console.log(`token: ${token}`)
    console.log(window.location.toString())

    if (token !== null) {
      formData.append("token", token)
      try {
        const res = await fetch("../api/user-actions/get-user.php", {
          method: "POST",
          body: formData,
        })
        const response = await res.json()
        if (response.success) {
          if (response.message.user.role === 'admin' && window.location.toString() === 'admin-dashboard') {
            window.location.reload()
          }
        } else {
          showErrorMessage(response.message)
        }
      } catch (error) {
        showErrorMessage(error)
      }
    } else {
      window.location.replace("/")
    }
  } else {
    window.location.replace("/")
  }
}

