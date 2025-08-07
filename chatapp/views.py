from django.shortcuts import render
from django.http import JsonResponse
from django.views.decorators.csrf import csrf_exempt
import json
import openai

openai.api_key = "API_KEY"

@csrf_exempt
def chat_view(request):
    if request.method == "POST":
        data = json.loads(request.body)
        message = data.get("message", "")

        if not message:
            return JsonResponse({"error": "No message provided."}, status=400)

        response = openai.ChatCompletion.create(
            model="gpt-4o",
            messages=[{"role": "user", "content": message}],
        )
        reply = response["choices"][0]["message"]["content"]
        return JsonResponse({"response": reply})

    return JsonResponse({"error": "Invalid request method."}, status=405)

