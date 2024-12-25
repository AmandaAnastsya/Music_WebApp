<script>
        function scrollToLogin() {
            const loginSection = document.getElementById("Login");
            if (loginSection) {
                loginSection.scrollIntoView({ behavior: "smooth" });
            }
        }
    </script>

<script>
    function openLoginModal() {
        const modal = document.getElementById("loginModal");
        if (modal) {
            modal.style.display = "block";
        }
    }

    function closeLoginModal() {
        const modal = document.getElementById("loginModal");
        if (modal) {
            modal.style.display = "none";
        }
    }

    // Menutup modal jika pengguna mengklik di luar modal
    window.onclick = function (event) {
        const modal = document.getElementById("loginModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
</script>

    
    <script>
      function playAudio(audioId) {
        const audioPlayer = document.getElementById(audioId);

        const allAudios = document.querySelectorAll("audio");
        allAudios.forEach((audio) => {
          if (!audio.paused && audio !== audioPlayer) {
            audio.pause();
            audio.currentTime = 0;
          }
        });

        if (audioPlayer.paused) {
          audioPlayer.play();
        } else {
          audioPlayer.pause();
          audioPlayer.currentTime = 0;
        }
      }
      
    </script>
  </body>
</html>
