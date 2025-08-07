# KiddingPOS - Smart E-Commerce & POS Website with AI Chatbot

**KiddingPOS** is a smart, web-based **E-Commerce and Point of Sale (POS)** system designed for small businesses and SMEs (UMKM). This project combines a **PHP-based frontend** with a **Django-powered AI chatbot**, creating a seamless experience for both customers and admins. Our platform provides local businesses with the digital tools they need to establish their online presence, manage their products, and reach customers effectively in the digital marketplace.

## Missions
To bridge the digital gap for Indonesian SMEs by providing an accessible, user-friendly e-commerce solution that enables small businesses to compete in the modern digital economy while preserving their local identity and community connections.

---

## 🚀 Key Features

- 🛒 Sales and purchase system
- 🔐 User authentication with dashboard (Admin & Customer roles)
- 💬 AI-powered chatbot (Python + Django)
- 📦 Product & transaction management
- 📱 Responsive frontend layout
- ☁️ Deployed via Infinity Tree hosting

---

## 🛠️ Tech Stack

| Component        | Technology                            |
|------------------|----------------------------------------|
| **Frontend**     | HTML, CSS, JavaScript, chat.js         |
| **Backend**      | PHP (auth, dashboard, database)        |
| **AI Chatbot**   | Python 3, Django (`views.py`)          |
| **Database**     | MySQL (via XAMPP / Laragon)            |
| **Hosting**      | Infinity Tree                          |

---
      
### How to Set up the Django Backend

```bash
cd django
python -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate
pip install -r requirements.txt 
python manage.py runserver
```
Django will run at http://127.0.0.1:8000/

## 💬 How the AI Chatbot Works
1. chat.js handles input from the user.
2. It sends a request to the Django API via JavaScript (AJAX or Fetch).
3. Django processes the message using your chatbot logic (e.g. OpenAI API or custom rules).
4. The response is sent back and shown to the user in real-time.
5. Make sure both PHP and Django servers are running, and the API endpoint URL in chat.js matches your Django backend

## 🤝 Contributing
This project is still in active development. Feel free to fork the repo, open issues, or submit pull requests for improvements!

Best,
Kidding
