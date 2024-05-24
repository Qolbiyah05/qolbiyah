from flask import *

app= Flask(__name__)

@app.route("/")
def index():
    return "<p>Hello, Pak SUGIYANTO!</p>"


@app.route("/template")
def template():
    nim ="55080"
    return render_template('template.html', nim=nim)

@app.route("/hello")
def hello():
    name = request.args.get('name')
    return render_template('hello.html', name=name)