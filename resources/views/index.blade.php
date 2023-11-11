@extends('layouts.guest')
@section('content')

    <section class="jumbotron text-center mt-5 mb-5">
        <div class="container">
            <h1 class="jumbotron-heading">Lets begin!</h1>
            <p class="lead text-muted">Choose your preferred source and customize your desired articles, and I'm here to make it easy for you.</p>
            <a href="/API/" class="btn btn-primary my-2"><i class="material-icons opacity-10">star</i>All in our Database<i class="material-icons opacity-10">star</i></a>
            <p>
                <a href="/API/?source=bbcNews" class="btn btn-dark my-2">BBC News</a>
                <a href="/API/?source=newsapi" class="btn btn-danger my-2">News-Api</a>
                <a href="/API/?source=guardians" class="btn btn-warning my-2">Guardians</a>
            </p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                <div class="col-12 text-center mb-4"><h4>Let's make a custom request!</h4></div>

                <div class="col-md-12">
                    <div class="card mb-4 box-shadow">
                        <div class="text-center pt-3 text-md">None of these are required , just fill what you want.</div>
                        <div class="card-body">
                            <form method="get" action="/API/">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                                        <input type="text" name="key" class="form-control px-3 py-2 border" placeholder="keyword"/>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                                        <select  name="source" class="form-control px-3 py-2 border" >
                                            <option value="database">Database</option>
                                            <option value="newsapi">News Api</option>
                                            <option value="guardians">Guardians</option>
                                            <option value="bbcNews">BBC News</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                                        <select  name="category" class="form-control px-3 py-2 border" >
                                            <option value="business">Business</option>
                                            <option value="entertainment">Entertainment</option>
                                            <option value="health">Health</option>
                                            <option value="science">Science</option>
                                            <option value="sports">Sports</option>
                                            <option value="technology">Technology</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                                        <input type="text" name="author" class="form-control px-3 py-2 border" placeholder="Author"/>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                                        <input type="date" name="dateFrom" class="form-control px-3 py-2 border" min="1997-01-01" max="2030-12-31" value="1997-01-01"/>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 mt-2">
                                        <input type="date" name="dateTo" class="form-control px-3 py-2 border" min="1997-01-01" max="2030-12-31" value="<?php echo date('Y-m-d'); ?>"/>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-info px-3 py-2">Create your Api link</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mb-4 box-shadow">
                        <div class="text-center pt-3 text-md text-dark">Any question? check these documentations :</div>
                        <div class="card-body">

                            <button class="accordion">Base Url?</button>
                            <div class="panel">
                                <p>
                                    Our base Url is {{url('/API/')}}.
                                    <br>
                                    You need to add your desired attribute to the end of this base url.
                                    <br>
                                    Separate your attributes using & symbol.
                                    <br>
                                    Sample : <a href="{{url('/API/?source=newsapi&page=1&pagesize=10')}}" target="_blank">{{url('/API/?source=newsapi&page=1&pagesize=10')}}</a>
                                </p>
                            </div>

                            <button class="accordion">You have a keyWord?</button>
                            <div class="panel">
                                <p>
                                    Add 'key' attribute in your query string.
                                    <br>
                                    This author should be in type of String.
                                    <br>
                                    Sample : <a href="{{url('/API/?key=Innoscripta')}}" target="_blank">{{url('/API/?key=Innoscripta')}}</a>
                                </p>
                            </div>

                            <button class="accordion">You Need a specific source?</button>
                            <div class="panel">
                                <p>
                                    Add 'source' attribute in your query string.
                                    <br>
                                    This source should be in : database ,bbcNews ,guardians, newsapi.
                                    <br>
                                    Sample :<a href="{{url('/API/?source=newsapi&page=1&pagesize=10')}}" target="_blank">{{url('/API/?source=newsapi&page=1&pagesize=10')}}</a>
                                </p>
                            </div>

                            <button class="accordion">You Need a specific Category?</button>
                            <div class="panel">
                                <p>
                                    Add 'category' attribute in your query string.
                                    <br>
                                    This category should be in : business, entertainment, health, science, sports, technology, other.
                                    <br>
                                    Sample : <a href="{{url('/API/?category=business')}}" target="_blank">{{url('/API/?category=business')}}</a>
                                </p>
                            </div>

                            <button class="accordion">You Know the Author?</button>
                            <div class="panel">
                                <p>
                                    Add 'author' attribute in your query string.
                                    <br>
                                    This author should be in type of String.
                                    <br>
                                    Sample : <a href="{{url('/API/?author=Ahmadreza')}}" target="_blank">{{url('/API/?author=Ahmadreza')}}</a>
                                </p>
                            </div>

                            <button class="accordion">From a specific Date?</button>
                            <div class="panel">
                                <p>
                                    Add 'dateFrom' attribute in your query string.
                                    <br>
                                    This dateFrom can be a Date in standard format (YYYY-MM-DD).
                                    <br>
                                    Sample : <a href="{{url('/API/?dateFrom=2020-10-25')}}" target="_blank">{{url('/API/?dateFrom=2020-10-25')}}</a>
                                </p>
                            </div>

                            <button class="accordion">To a specific Date?</button>
                            <div class="panel">
                                <p>
                                    Add 'dateTo' attribute in your query string.
                                    <br>
                                    This dateTo can be a Date in standard format (YYYY-MM-DD).
                                    <br>
                                    Sample : <a href="{{url('/API/?dateTo=2023-11-10')}}" target="_blank">{{url('/API/?dateTo=2023-11-10')}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
@endsection
