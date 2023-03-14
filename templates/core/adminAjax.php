<script>
  // Function
  let subject1 = "package"

  function deleteDataP(id) {
    $(document).ready(function() {
      $.ajax({
        url: 'ajax-deletePackages.php',
        type: 'POST',
        data: {
          id: id,
          action: "delete"
        },
        success: function(response) {
          if (response == 1) {
            location.reload();
          } else if (response == 0) {
            Swal.fire("Data Cannot Be Deleted");
          }
        }
      });
    });
  }
</script>
<script>
  // Function
  let subject2 = "lesson"

  function deleteDataC(id) {
    $(document).ready(function() {
      $.ajax({
        url: 'ajax-deleteClasses.php',
        type: 'POST',
        data: {
          id: id,
          action: "delete"
        },
        success: function(response) {
          if (response == 1) {
            location.reload();
          } else if (response == 0) {
            Swal.fire("Data Cannot Be Deleted");
          }
        }
      });
    });
  }
</script>
<script>
  // Function
  let subject3 = "instructor"

  function deleteDataI(id) {
    $(document).ready(function() {
      $.ajax({
        url: 'ajax-deleteInstructors.php',
        type: 'POST',
        data: {
          id: id,
          action: "delete"
        },
        success: function(response) {
          if (response == 1) {
            location.reload();
          } else if (response == 0) {
            Swal.fire("Data Cannot Be Deleted");
          }
        }
      });
    });
  }
</script>
<script>
  // Function
  let subject4 = "member"

  function deleteDataM(id) {
    $(document).ready(function() {
      $.ajax({
        url: 'ajax-deleteMembers.php',
        type: 'POST',
        data: {
          id: id,
          action: "delete"
        },
        success: function(response) {
          if (response == 1) {
            location.reload();
          } else if (response == 0) {
            Swal.fire("Data Cannot Be Deleted");
          }
        }
      });
    });
  }
</script>