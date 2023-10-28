from django.http import JsonResponse
from .inference import predict

def xssmodel(request):
    input_text = request.GET.get('text', '')
    prediction = predict(input_text)
    return JsonResponse({'prediction': prediction})