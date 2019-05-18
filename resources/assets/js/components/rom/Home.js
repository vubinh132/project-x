import React, {Component} from 'react';
import ReactTable from 'react-table';
import 'react-table/react-table.css';
import getOrdersUrl from '../ApiUrls';


class Home extends Component {

    constructor(props) {
        super(props);
        this.state = {
            isLoading: true,
            data: [],
            name: 'binhvq'
        };
    }

    componentDidMount() {
        $.ajax({
            url: 'http://localhost:8000/api/orders/get-orders?XDEBUG_SESSION_START=13236',
            type: 'POST',
            headers: {'api-key' : '123456@X'},
            data: {'conditions' : ['RN']},
            success: function (res) {
                console.log(res);
                this.setState({isLoading: false, data: res.data});
            }, error: function (xhr, status, error) {

            }
        })
    }

    render() {
        const data = [{
            name: 'Nguyen Van A',
            age: 26,
            friend: {
                name: 'Do Van C',
                age: 23,
            }
        }, {
            name: 'Dao Thi B',
            age: 22,
            friend: {
                name: 'Ngo Trung V',
                age: 24,
            }
        }, {
            name: 'Tran Duc C',
            age: 25,
            friend: {
                name: 'Ngo Thanh E',
                age: 25,
            }
        }, {
            name: 'Le Tien N',
            age: 27,
            friend: {
                name: 'Cao Cong G',
                age: 24,
            }
        }, {
            name: 'Pham Hoang M',
            age: 26,
            friend: {
                name: 'Lai Hai D',
                age: 25,
            }
        }, {
            name: 'Duong Van L',
            age: 23,
            friend: {
                name: 'Le Hoang M',
                age: 23,
            }
        }];

        const columns = [{
            Header: 'Name',
            accessor: 'name' // String-based value accessors!
        }, {
            Header: 'Age',
            accessor: 'age',
            Cell: props => <span className='number'>{props.value}</span> // Custom cell components!
        }, {
            id: 'friendName', // Required because our accessor is not a string
            Header: 'Friend Name',
            accessor: d => d.friend.name // Custom value accessors!
        }, {
            Header: props => <span>Friend Age</span>, // Custom header components!
            accessor: 'friend.age'
        }]

        if (this.state.isLoading) {
            return (
                <div className="react-loader">
                </div>
            )
        }
        return (
            <div>
                <ReactTable
                    data={data}
                    columns={columns}
                    defaultPageSize={10}
                />
            </div>
        )
    }
}

export default Home