function deleteStudent(studentId) {
    if (!confirm("Are you sure you want to delete this student?")) return;

    fetch("./backend/delete_user.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ student: studentId })
    })
    .then(res => res.json())
    .then(data => { 
        if (data.success) {
            alert(data.message);
            document.getElementById("student-row-" + studentId).remove();
            window.location.reload()
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(err => console.error(err));
}