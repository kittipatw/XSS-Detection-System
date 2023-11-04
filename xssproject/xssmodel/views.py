from django.http import JsonResponse
from .inference import predict
from django.views.decorators.csrf import csrf_exempt
import json

@csrf_exempt
def xssmodel(request):
    if request.method == "POST":
        data = json.loads(request.body.decode('utf-8'))
        input_text = data.get('input-text', '')
        prediction = predict(input_text)
        return JsonResponse({'prediction': prediction})
    else:
        return JsonResponse({'error': 'Only POST requests are allowed.'})


    # input_text = request.GET.get('text', '')
    # prediction = predict(input_text)
    # return JsonResponse({'prediction': prediction})