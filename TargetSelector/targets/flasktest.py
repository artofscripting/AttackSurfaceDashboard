from flask import Flask, request, render_template

app = Flask(__name__)

@app.route('/')
def my_form():
    return render_template('my-form.html')

@app.route('/', methods=['POST'])
def my_form_post():
    target = request.form['target']
    processed_text = target.upper()
    return processed_text
    
    
    
app.run(host='0.0.0.0', port=5000)
    
