const chatbox = document.getElementById("chatbox");
const input = document.getElementById("user-input");
const sendBtn = document.getElementById("send-btn");

sendBtn.addEventListener("click", async () => {
  const userMessage = input.value.trim();
  if (!userMessage) return;

  // Tampilkan pesan user
  chatbox.innerHTML += `<div class="mb-2"><strong>Anda:</strong> ${userMessage}</div>`;
  input.value = "";

  // Kirim ke backend Django
  const response = await fetch("http://127.0.0.1:8000/", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ message: userMessage }),
  });

  const data = await response.json();

  // Tampilkan respon dari AI
  chatbox.innerHTML += `<div class="mb-4"><strong>AI:</strong> ${data.response}</div>`;
  chatbox.scrollTop = chatbox.scrollHeight;
});

