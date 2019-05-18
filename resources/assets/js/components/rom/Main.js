import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {HashRouter, Link, Route, Switch} from 'react-router-dom';
import Home from "./Home";
import About from "./About";


class Main extends Component {
    constructor(props) {
        super(props);
        this.state = {name: 'binhvq'};
    }

    render() {
        return (
            <HashRouter>
                <div className="container-fluid">
                    <div className="row bg-title">
                        <div className="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <h4 className="page-title">ROM</h4>
                            <Link className="btn btn-primary btn-nav" to={'/'}>Home Page</Link>
                            <Link className="btn btn-primary btn-nav" to={'/about'}>Confirmation Page</Link>
                        </div>
                        <div className="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                            <ol className="breadcrumb">
                                <li><a href="">Home</a></li>
                                <li className="active">ROM</li>
                            </ol>
                        </div>
                    </div>
                    <div className="white-box"><RouterPath/></div>
                </div>
            </HashRouter>
        );
    }
}

class RouterPath extends Component {
    render() {
        return (
            <main>
                <Switch>
                    <Route exact path='/' component={Home}/>
                    <Route exact path='/about' component={About}/>
                </Switch>
            </main>
        )
    }
}

if (document.getElementById('page-wrapper')) {
    ReactDOM.render(<Main/>, document.getElementById('page-wrapper'));
}
