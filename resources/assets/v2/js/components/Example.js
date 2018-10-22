import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export default class Example extends Component {
    render() {
        return (
            <div className="container">
                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <div className="panel panel-default">
                            <div className="panel-heading">Example Component</div>

                            <div className="panel-body">
                                I'm an example component!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

Array.prototype.forEach.call(
    document.getElementsByClassName('component-example'),
    function(element) {
        ReactDOM.render(
            <Example/>,
            element
        )
    }
);
