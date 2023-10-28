from transformers import AutoModelForSequenceClassification, AutoTokenizer
import torch
from os.path import dirname

model_path = f"{dirname(__file__)}/model/"

model = AutoModelForSequenceClassification.from_pretrained(model_path)
tokenizer = AutoTokenizer.from_pretrained(model_path)

def predict(text, model=model, tokenizer=tokenizer):
    # Tokenize the input text
    inputs = tokenizer(text, return_tensors="pt", max_length=512, truncation=True)

    # Make prediction
    with torch.no_grad():
        logits = model(**inputs).logits

    # Get the predicted class (you can modify this if you want to get probabilities with softmax)
    predicted_class = torch.argmax(logits, dim=1).item()

    return predicted_class